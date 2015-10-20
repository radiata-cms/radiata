<?php

namespace common\modules\banner\models;

use Yii;

/**
 * This is the model class for table "{{%banner_stat}}".
 *
 * @property integer $banner_id
 * @property integer $views
 * @property integer $clicks
 * @property double $ctr
 *
 * @property Banner $banner
 */
class BannerStat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_stat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id'], 'required'],
            [['banner_id', 'views', 'clicks'], 'integer'],
            [['ctr'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banner_id' => Yii::t('b/banner', 'Banner ID'),
            'views'     => Yii::t('b/banner', 'Views'),
            'clicks'    => Yii::t('b/banner', 'Clicks'),
            'ctr'       => Yii::t('b/banner', 'Ctr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'banner_id']);
    }
}
