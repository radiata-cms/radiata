<?php

namespace common\modules\vote\models;

use backend\modules\radiata\behaviors\TranslateableBehavior;
use Yii;

/**
 * This is the model class for table "{{%vote_option}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $position
 * @property integer $total_votes
 * @property double $percent
 *
 * @property VoteTranslation[] $translations
 * @property VoteLog[] $voteLogs
 * @property Vote $vote
 */
class VoteOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'position', 'total_votes'], 'integer'],
            [['percent'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            'title' => Yii::t('b/vote/option', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(VoteOptionTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteLogs()
    {
        return $this->hasMany(VoteLog::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(Vote::className(), ['id' => 'parent_id']);
    }
}
