<?php

namespace common\modules\news\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%news_gallery_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $image_text
 *
 * @property Lang $language
 * @property News $parent
 */
class NewsGalleryTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_gallery_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['image_text'], 'string'],
            [['locale'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id'  => Yii::t('c/news/gallery', 'Parent ID'),
            'locale'     => Yii::t('c/news/gallery', 'Locale'),
            'image_text' => Yii::t('c/news/gallery', 'Image Text'),
        ];
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
    public function getParent()
    {
        return $this->hasOne(NewsGallery::className(), ['id' => 'parent_id']);
    }
}
