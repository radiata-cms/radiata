<?php

namespace common\modules\page\models;

use common\modules\radiata\models\Lang;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%page_page_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Lang $language
 * @property Page $parent
 */
class PageTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_page_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['parent_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['locale'], 'string', 'max' => 20],
            [['slug'], 'string', 'max' => 100],
            [['title', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255]
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
                'uniqueSlugGenerator' => function ($baseSlug) {
                    return $baseSlug;
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
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }
}
