<?php

namespace common\modules\news\models;

use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%news_tags}}".
 *
 * @property integer $id
 * @property integer $frequency
 *
 * @property NewsTag[] $newsNewsTag
 * @property News[] $news
 * @property NewsTagTranslation[] $newsTagTranslations
 * @property Lang[] $locales
 */
class NewsTag extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_tags}}';
    }

    /**
     * @inheritdoc
     * @return \common\modules\news\models\active_query\NewsTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\news\models\active_query\NewsTagQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['name'],
                'translationLanguageAttribute' => 'locale',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('b/news/tag', 'ID'),
            'name'      => Yii::t('b/news/tag', 'Name'),
            'frequency' => Yii::t('b/news/tag', 'Frequency'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsNewsTag()
    {
        return $this->hasMany(NewsTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('{{%news_news_tags}}', ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTagTranslations()
    {
        return $this->hasMany(NewsTagTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocales()
    {
        return $this->hasMany(Lang::className(), ['locale' => 'locale'])->viaTable('{{%news_tags_translation}}', ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsTagTranslation::className(), ['parent_id' => 'id']);
    }
}
