<?php
namespace common\modules\news\models\active_query;

use Yii;
use yii\db\ActiveQuery;

class NewsActiveQuery extends ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->andWhere(['locale' => $locale]);
    }
}