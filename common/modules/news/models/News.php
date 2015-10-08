<?php

namespace common\modules\news\models;

use backend\forms\DateTimeValidator;
use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\DateTimeBehavior;
use backend\modules\radiata\behaviors\ImageUploadBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\models\user\User;
use common\modules\news\models\active_query\NewsActiveQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%news_news}}".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $category_id
 * @property integer $status
 * @property string $image
 * @property string $image_description
 * @property string $redirect
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property NewsCategory $category
 * @property User $createdBy
 * @property User $updatedBy
 * @property NewsCategory[] $categories
 * @property NewsTranslation[] $translations
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'category_id', 'status'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['date'], DateTimeValidator::className()],
            [['image_description', 'redirect'], 'string', 'max' => 255],
            [['image'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            DateTimeBehavior::className(),
            CacheBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'title',
                'icon'           => 'fa-bars bg-olive',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'slug', 'description', 'content', 'image_description', 'redirect', 'meta_title', 'meta_keywords', 'meta_description'],
                'translationLanguageAttribute' => 'locale',
            ],
            [
                'class'     => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'thumbs'    => [
                    'small' => ['width' => 150, 'height' => 100],
                    'big'   => ['width' => 450, 'height' => 150],
                ],
                'filePath'  => '@frontend/web/uploads/news/[[pk]]/[[pk]].[[extension]]',
                'fileUrl'   => '/uploads/news/[[pk]]/[[pk]].[[extension]]',
                'thumbPath' => '@frontend/web/uploads/news/[[pk]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl'  => '/uploads/news/[[pk]]/[[profile]]_[[pk]].[[extension]]',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('b/news', 'ID'),
            'date'              => Yii::t('b/news', 'Date'),
            'category_id'       => Yii::t('b/news', 'Category'),
            'status'            => Yii::t('b/news', 'Status'),
            'image'             => Yii::t('b/news', 'Image'),
            'slug'              => Yii::t('b/news', 'Slug'),
            'title'             => Yii::t('b/news', 'Title'),
            'description'       => Yii::t('b/news', 'Description'),
            'content'           => Yii::t('b/news', 'Content'),
            'image_description' => Yii::t('b/news', 'Image Description'),
            'redirect'          => Yii::t('b/news', 'Redirect'),
            'meta_title'        => Yii::t('b/news', 'Meta title'),
            'meta_keywords'     => Yii::t('b/news', 'Meta keywords'),
            'meta_description'  => Yii::t('b/news', 'Meta description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
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
    public function getCategories()
    {
        return $this->hasMany(NewsCategory::className(), ['id' => 'category_id'])->viaTable('{{%news_news_category}}', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsTranslation::className(), ['parent_id' => 'id']);
    }

    public static function find()
    {
        return new NewsActiveQuery(get_called_class());
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/news', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/news', 'status' . self::STATUS_DISABLED),
        ];
    }
}
