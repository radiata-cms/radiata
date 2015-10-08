<?php

namespace common\modules\news\models;

use common\modules\radiata\models\Lang;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%news_news_translation}}".
 *
 * @property integer $parent_id
 * @property string $lang
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $redirect
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
            [['title'], 'required'],
            [['parent_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['locale'], 'string', 'max' => 20],
            [['slug'], 'string', 'max' => 100],
            [['title', 'redirect', 'image_description', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id'         => Yii::t('b/news', 'Parent ID'),
            'locale'            => Yii::t('b/news', 'Locale'),
            'slug'              => Yii::t('b/news', 'Slug'),
            'title'             => Yii::t('b/news', 'Title'),
            'description'       => Yii::t('b/news', 'Description'),
            'content'           => Yii::t('b/news', 'Content'),
            'redirect'          => Yii::t('b/news', 'Redirect'),
            'image_description' => Yii::t('b/news', 'Image description'),
            'meta_title'        => Yii::t('b/news', 'Meta Title'),
            'meta_keywords'     => Yii::t('b/news', 'Meta Keywords'),
            'meta_description'  => Yii::t('b/news', 'Meta Description'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'               => SluggableBehavior::className(),
                'attribute'           => 'title',
                'slugAttribute'       => 'slug',
                'immutable'           => true,
                'ensureUnique'        => true,
                'uniqueSlugGenerator' => function ($baseSlug, $iteration, $model) {
                    return $baseSlug . '-' . $model->lang . '-' . $model->parent_id;
                }
            ],
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
