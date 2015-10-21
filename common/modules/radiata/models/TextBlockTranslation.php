<?php

namespace common\modules\radiata\models;

use Yii;

/**
 * This is the model class for table "{{%radiata_textblock_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $text
 *
 * @property Lang $language
 * @property TextBlock $parent
 */
class TextBlockTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_textblock_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['parent_id'], 'integer'],
            [['text'], 'string'],
            [['locale'], 'string', 'max' => 20]
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
        return $this->hasOne(TextBlock::className(), ['id' => 'parent_id']);
    }
}
