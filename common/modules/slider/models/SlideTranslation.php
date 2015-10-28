<?php

namespace common\modules\slider\models;

use common\modules\radiata\models\Lang;
use Yii;

/**
 * This is the model class for table "{{%slider_slide_translation}}".
 *
 * @property integer $parent_id
 * @property string $locale
 * @property string $title
 * @property string $description
 * @property string $link
 *
 * @property Lang $language
 * @property Slide $parent
 */
class SlideTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_slide_translation}}';
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
            [['title', 'description', 'link'], 'string', 'max' => 255]
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
        return $this->hasOne(Slide::className(), ['id' => 'parent_id']);
    }
}
