<?php

namespace common\modules\slider\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\ImageUploadBehavior;
use backend\modules\radiata\behaviors\PositionBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\models\user\User;
use common\modules\slider\models\active_query\SlideActiveQuery;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%slider_slide}}".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property string $image
 * @property integer $status
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property SlideTranslation[] $translations
 * @property Slider $slider
 * @property User $createdBy
 * @property User $updatedBy
 */
class Slide extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_slide}}';
    }

    public static function find()
    {
        return new SlideActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'slider_id'], 'required'],
            [['slider_id', 'position'], 'integer'],
            ['status', 'in', 'range' => array_keys($this->getStatusesList())],
        ];
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/slider/slide', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/slider/slide', 'status' . self::STATUS_DISABLED),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class'             => PositionBehavior::className(),
                'parentIdAttribute' => 'slider_id',
            ],
            CacheBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'title',
                'icon'           => 'fa-sliders bg-tan',
            ],
            [
                'class'     => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'thumbs'    => [
                    'slide' => ['width' => 1400, 'height' => 730],
                ],
                'filePath'  => '@frontend/web/uploads/slide/[[pk]]/[[pk]].[[extension]]',
                'fileUrl'   => '/uploads/slide/[[pk]]/[[pk]].[[extension]]',
                'thumbPath' => '@frontend/web/uploads/slide/[[pk]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl'  => '/uploads/slide/[[pk]]/[[profile]]_[[pk]].[[extension]]',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'description', 'link'],
                'translationLanguageAttribute' => 'locale',
            ],
            [
                'class'             => SortableGridBehavior::className(),
                'sortableAttribute' => 'position'
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('b/slider/slide', 'ID'),
            'slider_id'   => Yii::t('b/slider/slide', 'Slider'),
            'title'       => Yii::t('b/slider/slide', 'Title'),
            'description' => Yii::t('b/slider/slide', 'Description'),
            'link'        => Yii::t('b/slider/slide', 'Link'),
            'status'      => Yii::t('b/slider/slide', 'Status'),
            'position'    => Yii::t('b/slider/slide', 'Position'),
            'image'       => Yii::t('b/slider/slide', 'Image'),
            'created_at'  => Yii::t('b/slider/slide', 'Created At'),
            'updated_at'  => Yii::t('b/slider/slide', 'Updated At'),
            'created_by'  => Yii::t('b/slider/slide', 'Created By'),
            'updated_by'  => Yii::t('b/slider/slide', 'Updated By'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getSlider()
    {
        return $this->hasOne(Slider::className(), ['id' => 'slider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(SlideTranslation::className(), ['parent_id' => 'id']);
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
}
