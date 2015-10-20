<?php
namespace common\modules\news\models\active_query;

use creocoder\taggable\TaggableQueryBehavior;
use Yii;
use yii\db\ActiveQuery;

class NewsActiveQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }

    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->joinWith(['translations'])->andWhere(['locale' => $locale]);
    }
}