<?php

namespace common\modules\news\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%news_news_translation}}".
 *
 * @property integer $parent_id
 * @property string $lang
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Lang $language
 * @property News $parent
 */
class NewsTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_news_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'locale', 'slug', 'title'], 'required'],
            [['parent_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['locale'], 'string', 'max' => 20],
            [['slug'], 'string', 'max' => 100],
            [['title', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id'        => Yii::t('b/news/news', 'Parent ID'),
            'locale'           => Yii::t('b/news/news', 'Locale'),
            'slug'             => Yii::t('b/news/news', 'Slug'),
            'title'            => Yii::t('b/news/news', 'Title'),
            'description'      => Yii::t('b/news/news', 'Description'),
            'content'          => Yii::t('b/news/news', 'Content'),
            'meta_title'       => Yii::t('b/news/news', 'Meta Title'),
            'meta_keywords'    => Yii::t('b/news/news', 'Meta Keywords'),
            'meta_description' => Yii::t('b/news/news', 'Meta Description'),
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
        return $this->hasOne(News::className(), ['id' => 'parent_id']);
    }
}
