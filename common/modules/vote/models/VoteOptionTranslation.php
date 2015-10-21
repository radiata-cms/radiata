<?php

namespace common\modules\vote\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%vote_option_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $title
 *
 * @property Lang $locale0
 * @property Vote $parent
 */
class VoteOptionTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_option_translation}}';
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
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => Yii::t('b/vote/option', 'Parent ID'),
            'locale'    => Yii::t('b/vote/option', 'Locale'),
            'title'     => Yii::t('b/vote/option', 'Title'),
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
        return $this->hasOne(VoteOption::className(), ['id' => 'parent_id']);
    }
}
