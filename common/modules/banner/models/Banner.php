<?php

namespace common\modules\banner\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\DateTimeBehavior;
use backend\modules\radiata\behaviors\ImageUploadBehavior;
use common\models\user\User;
use common\modules\banner\models\active_query\BannerActiveQuery;
use common\modules\radiata\models\Lang;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%banner_banner}}".
 *
 * @property integer $id
 * @property string $locale
 * @property integer $place_id
 * @property integer $date_start
 * @property integer $date_end
 * @property string $title
 * @property string $html
 * @property string $image
 * @property string $link
 * @property integer $new_wnd
 * @property integer $status
 * @property integer $priority
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property BannerPlace $place
 * @property User $createdBy
 * @property User $updatedBy
 * @property BannerStat $stat
 * @property Lang $language
 */
class Banner extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'place_id', 'title'], 'required'],
            [['place_id', 'new_wnd', 'status', 'priority'], 'integer'],
            [['date_start', 'date_end'], 'date', 'format' => Yii::t('b/radiata/settings', 'dateFormat')],
            [['html'], 'string'],
            [['locale'], 'string', 'max' => 20],
            [['title', 'link'], 'string', 'max' => 255]
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            CacheBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'title',
                'icon'           => 'fa-flag bg-maroon',
            ],
            [
                'class'     => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'filePath'  => '@frontend/web/uploads/banner/[[pk]]/[[pk]].[[extension]]',
                'fileUrl'   => '/uploads/banner/[[pk]]/[[pk]].[[extension]]',
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('b/banner', 'ID'),
            'locale'     => Yii::t('b/banner', 'Locale'),
            'place_id'   => Yii::t('b/banner', 'Place'),
            'date_start' => Yii::t('b/banner', 'Date Start'),
            'date_end'   => Yii::t('b/banner', 'Date End'),
            'title'      => Yii::t('b/banner', 'Title'),
            'html'       => Yii::t('b/banner', 'Html'),
            'image'      => Yii::t('b/banner', 'Image'),
            'link'       => Yii::t('b/banner', 'Link'),
            'new_wnd'    => Yii::t('b/banner', 'New Wnd'),
            'status'     => Yii::t('b/banner', 'Status'),
            'priority'   => Yii::t('b/banner', 'Priority'),
            'created_at' => Yii::t('b/banner', 'Created At'),
            'updated_at' => Yii::t('b/banner', 'Updated At'),
            'created_by' => Yii::t('b/banner', 'Created By'),
            'updated_by' => Yii::t('b/banner', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(BannerPlace::className(), ['id' => 'place_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Lang::className(), ['locale' => 'locale']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getStat()
    {
        return $this->hasOne(BannerStat::className(), ['banner_id' => 'id']);
    }

    public static function find()
    {
        return new BannerActiveQuery(get_called_class());
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/banner', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/banner', 'status' . self::STATUS_DISABLED),
        ];
    }

    public function beforeSave($insert)
    {
        if(strtotime($this->date_end) > 0 && strtotime($this->date_end) < time()) {
            $this->status = self::STATUS_DISABLED;
        }

        return parent::beforeSave($insert);
    }
}
