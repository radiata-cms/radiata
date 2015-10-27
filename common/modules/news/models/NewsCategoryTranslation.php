<?php

namespace common\modules\news\models;

use common\modules\radiata\models\Lang;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%news_category_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $slug
 * @property string $title
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property Lang $language
 * @property NewsCategory $parent
 */
class NewsCategoryTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id'], 'integer'],
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
                'uniqueSlugGenerator' => [$this, 'uniqueSlugGenerator'],
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
        return $this->hasOne(NewsCategory::className(), ['id' => 'parent_id']);
    }

    public function uniqueSlugGenerator($baseSlug, $iteration, $model)
    {
        return $baseSlug . '-' . $model->language->code . '-' . ($iteration + 1);
    }
}
