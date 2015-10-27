<?php
namespace common\modules\news\models\active_query;

use common\modules\news\models\NewsCategory;
use Yii;
use yii\db\ActiveQuery;

class NewsCategoryActiveQuery extends ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->joinWith(['translations'])->andWhere(['locale' => $locale]);
    }

    public function active()
    {
        $this->andWhere(['status' => NewsCategory::STATUS_ACTIVE]);

        return $this;
    }
}