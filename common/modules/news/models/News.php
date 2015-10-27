<?php

namespace common\modules\news\models;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use arogachev\ManyToMany\validators\ManyToManyValidator;
use backend\forms\DateTimeValidator;
use backend\modules\news\behaviors\TaggableBehavior;
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
 * @property NewsGallery[] $gallery
 * @property NewsTag[] $tags
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    public $categories = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_news}}';
    }

    public static function find()
    {
        return new NewsActiveQuery(get_called_class());
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
            [['image', 'tagIds'], 'safe'],
            ['categories', ManyToManyValidator::className()],
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
            ['class' => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'slug', 'description', 'content', 'image_description', 'redirect', 'meta_title', 'meta_keywords', 'meta_description'],
                'translationLanguageAttribute' => 'locale',
            ],
            [
                'class'     => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'defaultImage' => '/images/no_image.png',
                'thumbs'    => [
                    'small' => ['width' => 150, 'height' => 100],
                    'big'   => ['width' => 450, 'height' => 150],
                ],
                'filePath'  => '@frontend/web/uploads/news/[[pk]]/[[pk]].[[extension]]',
                'fileUrl'   => '/uploads/news/[[pk]]/[[pk]].[[extension]]',
                'thumbPath' => '@frontend/web/uploads/news/[[pk]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl'  => '/uploads/news/[[pk]]/[[profile]]_[[pk]].[[extension]]',
            ],
            [
                'class'     => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'categories',
                        'table'             => '{{%news_news_category}}',
                        'ownAttribute'      => 'news_id',
                        'relatedModel'      => NewsCategory::className(),
                        'relatedAttribute'  => 'category_id',
                        'fillingRoute'      => [
                            'news/news/create',
                            'news/news/update',
                        ]
                    ],
                ],
            ],
            [
                'class' => TaggableBehavior::className(),
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
            'id'                => Yii::t('b/news', 'ID'),
            'date'              => Yii::t('b/news', 'Date'),
            'category_id'       => Yii::t('b/news', 'Category'),
            'categories' => Yii::t('b/news', 'Categories'),
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
            'tagIds'     => Yii::t('b/news', 'Tag Ids'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasMany(NewsGallery::className(), ['parent_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(NewsTag::className(), ['id' => 'tag_id'])->viaTable('{{%news_news_tags}}', ['news_id' => 'id']);
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

    public function saveGallery()
    {
        $fileIndex = 0;
        $position = 1;
        $activeLocale = Yii::$app->getModule('radiata')->activeLanguage['locale'];
        $galleryDeletedItems = Yii::$app->request->post('GalleryDeletedItems', []);

        $newsGalleryTranslation = Yii::$app->request->post('NewsGalleryTranslation', []);
        if(isset($newsGalleryTranslation[$activeLocale])) {
            foreach ($newsGalleryTranslation[$activeLocale] as $galId => $data) {
                if(in_array($galId, $galleryDeletedItems)) {
                    continue;
                }

                if($galId < 0) {
                    $galleryModel = new NewsGallery();
                } else {
                    $galleryModel = NewsGallery::findOne($galId);
                }

                if(!$galleryModel) {
                    $this->addError('gallery', Yii::t('b/news/gallery', 'Failed to load gallery'));

                    return false;
                }

                if($galId < 0) {
                    $galleryModel->gallery_id = $fileIndex++;
                } else {
                    $galleryModel->gallery_id = -1;
                }

                foreach (Yii::$app->request->post('NewsGalleryTranslation', []) as $language => $translateData) {
                    $translateData = $translateData[$galId];
                    foreach ($translateData as $attribute => $translation) {
                        if($translation) {
                            $galleryModel->translate($language)->$attribute = $translation;
                        }
                    }
                }

                $galleryModel->load($data);
                $galleryModel->position = $position++;
                $galleryModel->parent_id = $this->id;

                if(!$galleryModel->save()) {
                    foreach ($galleryModel->getErrors() as $error) {
                        $this->addError('gallery', $error[0]);
                    }

                    return false;
                }
            }
        }

        if($galleryDeletedItems) {
            foreach ($galleryDeletedItems as $galId) {
                $galleryModel = NewsGallery::findOne($galId);
                if(!$galleryModel->delete()) {
                    return false;
                }
            }
        }

        return true;
    }
}
