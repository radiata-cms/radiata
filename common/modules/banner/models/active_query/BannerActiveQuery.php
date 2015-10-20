<?php
namespace common\modules\banner\models\active_query;

use Yii;
use yii\db\ActiveQuery;

class BannerActiveQuery extends ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->andWhere(['or', ['locale' => $locale], ['locale' => null]]);
    }
}