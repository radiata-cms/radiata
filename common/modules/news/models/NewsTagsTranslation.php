<?php

namespace common\modules\news\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%news_tags_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $name
 *
 * @property Lang $language
 * @property NewsTags $parent
 */
class NewsTagsTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_tags_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['locale'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => Yii::t('b/news/tags', 'Parent ID'),
            'locale'    => Yii::t('b/news/tags', 'Locale'),
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
        return $this->hasOne(NewsTags::className(), ['id' => 'parent_id']);
    }
}
