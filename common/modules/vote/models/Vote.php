<?php

namespace common\modules\vote\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\DateTimeBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\models\user\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%vote_vote}}".
 *
 * @property integer $id
 * @property string $locale
 * @property integer $date_start
 * @property integer $date_end
 * @property integer $status
 * @property integer $type
 * @property integer $total_votes
 * @property integer $total_answers
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property VoteTranslation[] $translations
 * @property VoteOption[] $voteOptions
 * @property User $createdBy
 * @property User $updatedBy
 */
class Vote extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    const TYPE_SINGLE = 1;
    const TYPE_MULTI = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_vote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['total_votes', 'total_answers'], 'integer'],
            [['date_start', 'date_end'], 'date', 'format' => Yii::t('b/radiata/settings', 'dateFormat')],
            ['status', 'in', 'range' => array_keys($this->getStatusesList())],
            ['type', 'in', 'range' => array_keys($this->getTypesList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            CacheBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'title',
                'icon'           => 'fa-question-circle bg-aqua',
            ],
            [
                'class'      => DateTimeBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['date_start', 'date_end'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['date_start', 'date_end'],
                    BaseActiveRecord::EVENT_AFTER_FIND    => ['date_start', 'date_end'],
                ],
                'format'     => 'datePHPFormat',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title'],
                'translationLanguageAttribute' => 'locale',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            'create' => self::OP_INSERT,
            'update' => self::OP_UPDATE,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('b/vote', 'ID'),
            'title'         => Yii::t('b/vote', 'Title'),
            'date_start'    => Yii::t('b/vote', 'Date Start'),
            'date_end'      => Yii::t('b/vote', 'Date End'),
            'status'        => Yii::t('b/vote', 'Status'),
            'type'          => Yii::t('b/vote', 'Type'),
            'total_votes'   => Yii::t('b/vote', 'Total Votes'),
            'total_answers' => Yii::t('b/vote', 'Total Answers'),
            'created_at'    => Yii::t('b/vote', 'Created At'),
            'updated_at'    => Yii::t('b/vote', 'Updated At'),
            'created_by'    => Yii::t('b/vote', 'Created By'),
            'updated_by'    => Yii::t('b/vote', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteOptions()
    {
        return $this->hasMany(VoteOption::className(), ['parent_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(VoteTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     * @return \common\modules\vote\models\active_query\VoteActiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\vote\models\active_query\VoteActiveQuery(get_called_class());
    }

    /**
     * Get types list
     */
    public function getTypesList()
    {
        return [
            self::TYPE_SINGLE => Yii::t('b/vote', 'type' . self::TYPE_SINGLE),
            self::TYPE_MULTI  => Yii::t('b/vote', 'type' . self::TYPE_MULTI),
        ];
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/vote', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/vote', 'status' . self::STATUS_DISABLED),
        ];
    }

    public function beforeSave($insert)
    {
        if(strtotime($this->date_end) > 0 && strtotime($this->date_end) < time()) {
            $this->status = self::STATUS_DISABLED;
        }

        return parent::beforeSave($insert);
    }

    public function saveOptions()
    {
        $position = 1;
        $activeLocale = Yii::$app->getModule('radiata')->activeLanguage['locale'];
        $optionDeletedItems = Yii::$app->request->post('OptionDeletedItems', []);

        $voteOptionTranslation = Yii::$app->request->post('VoteOptionTranslation', []);
        if(isset($voteOptionTranslation[$activeLocale])) {
            foreach ($voteOptionTranslation[$activeLocale] as $optionId => $data) {
                if(in_array($optionId, $optionDeletedItems) || !is_numeric($optionId)) {
                    continue;
                }

                if($optionId < 0) {
                    $optionModel = new VoteOption();
                } else {
                    $optionModel = VoteOption::findOne($optionId);
                }

                if(!$optionModel) {
                    $this->addError('options', Yii::t('b/vote/option', 'Failed to load option'));

                    return false;
                }

                foreach (Yii::$app->request->post('VoteOptionTranslation', []) as $language => $translateData) {
                    $translateData = $translateData[$optionId];
                    foreach ($translateData as $attribute => $translation) {
                        $optionModel->translate($language)->$attribute = $translation;
                    }
                }

                $optionModel->position = $position++;
                $optionModel->parent_id = $this->id;

                if(!$optionModel->save()) {
                    foreach ($optionModel->getErrors() as $error) {
                        $this->addError('options', $error[0]);
                    }

                    return false;
                }
            }
        }

        if($position < 3) {
            $this->addError('options', Yii::t('b/vote/option', 'Add at least two options'));

            return false;
        }

        if($optionDeletedItems) {
            foreach ($optionDeletedItems as $optionId) {
                $optionModel = VoteOption::findOne($optionId);
                if(!$optionModel->delete()) {
                    return false;
                }
            }
        }

        return true;
    }
}
