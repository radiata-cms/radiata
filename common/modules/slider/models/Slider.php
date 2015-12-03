<?php

namespace common\modules\slider\models;

use Yii;

/**
 * This is the model class for table "{{%slider_place}}".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Slide[] $slides
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_slider}}';
    }

    static function getSlidersForDropDown()
    {
        $placesAll = self::find()->orderBy(['title' => SORT_ASC])->all();
        $places = [];

        foreach ($placesAll as $place) {
            $places[$place->id] = $place->title;
        }

        return $places;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('b/slider', 'ID'),
            'title' => Yii::t('b/slider', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlides()
    {
        return $this->hasMany(Slide::className(), ['slider_id' => 'id']);
    }
}
