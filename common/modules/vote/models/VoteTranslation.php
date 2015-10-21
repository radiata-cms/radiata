<?php

namespace common\modules\vote\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%vote_vote_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $title
 *
 * @property Lang $language
 * @property Vote $parent
 */
class VoteTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_vote_translation}}';
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
            'parent_id' => Yii::t('b/vote', 'Parent ID'),
            'locale'    => Yii::t('b/vote', 'Locale'),
            'title'     => Yii::t('b/vote', 'Title'),
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
        return $this->hasOne(Vote::className(), ['id' => 'parent_id']);
    }
}
