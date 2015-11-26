<?php

namespace common\modules\news\models;

use backend\modules\radiata\behaviors\ImageUploadBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\modules\news\models\active_query\NewsGalleryActiveQuery;
use Yii;

/**
 * This is the model class for table "{{%news_gallery}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $position
 * @property string $image
 *
 * @property News $parent
 * @property NewsGalleryTranslation[] $translations
 */
class NewsGallery extends \yii\db\ActiveRecord
{
    /*
     * Needed for tabular files(images) input
     */
    public $gallery_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_gallery}}';
    }

    public static function find()
    {
        return new NewsGalleryActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['parent_id', 'position'], 'integer'],
            [['image'], 'safe'],
        ];
    }

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
            'id'        => Yii::t('c/news/gallery', 'ID'),
            'parent_id' => Yii::t('c/news/gallery', 'Parent ID'),
            'position'  => Yii::t('c/news/gallery', 'Position'),
            'image'     => Yii::t('c/news/gallery', 'Image'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'            => ImageUploadBehavior::className(),
                'attribute'        => 'image',
                'tabularAttribute' => 'gallery_id',
                'thumbs'           => [
                    'small' => ['width' => 150, 'height' => 100],
                    'big'   => ['width' => 450, 'height' => 150],
                ],
                'filePath'  => '@frontend/web/uploads/news_gallery/[[id_path]]/[[pk]].[[extension]]',
                'fileUrl'   => '/uploads/news_gallery/[[id_path]]/[[pk]].[[extension]]',
                'thumbPath' => '@frontend/web/uploads/news_gallery/[[id_path]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl'  => '/uploads/news_gallery/[[id_path]]/[[profile]]_[[pk]].[[extension]]',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['image_text'],
                'translationLanguageAttribute' => 'locale',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsGalleryTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(News::className(), ['id' => 'parent_id']);
    }
}
