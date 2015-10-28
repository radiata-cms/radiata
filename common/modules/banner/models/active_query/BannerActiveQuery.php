<?php
namespace common\modules\banner\models\active_query;

use common\modules\banner\models\Banner;
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

    public function active()
    {
        $this->andWhere(['status' => Banner::STATUS_ACTIVE]);

        return $this;
    }
}