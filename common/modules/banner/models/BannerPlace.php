<?php

namespace common\modules\banner\models;

use Yii;

/**
 * This is the model class for table "{{%banner_place}}".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Banner[] $banners
 */
class BannerPlace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_place}}';
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
            'id'    => Yii::t('b/banner/place', 'ID'),
            'title' => Yii::t('b/banner/place', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banner::className(), ['place_id' => 'id']);
    }

    static function getPlacesForDropDown()
    {
        $placesAll = self::find()->orderBy(['title' => SORT_ASC])->all();
        $places = [];

        foreach ($placesAll as $place) {
            $places[$place->id] = $place->title;
        }

        return $places;
    }
}
