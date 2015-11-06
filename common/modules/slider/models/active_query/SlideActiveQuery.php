<?php
namespace common\modules\slider\models\active_query;

use common\modules\slider\models\Slide;
use Yii;
use yii\db\ActiveQuery;

class SlideActiveQuery extends ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->innerJoinWith(['translations'])->andWhere(['locale' => $locale]);
    }

    public function active()
    {
        $this->andWhere(['status' => Slide::STATUS_ACTIVE]);

        return $this;
    }

    public function order()
    {
        $this->orderBy(['position' => SORT_ASC]);

        return $this;
    }


}