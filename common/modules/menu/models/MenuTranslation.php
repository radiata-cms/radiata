<?php

namespace common\modules\menu\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%menu_menu_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $title
 *
 * @property Lang $language
 * @property Menu $parent
 */
class MenuTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_menu_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['parent_id'], 'integer'],
            [['locale'], 'string', 'max' => 20],
            [['title', 'link'], 'string', 'max' => 255]
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
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }
}
