<?php

namespace common\modules\news\models\active_query;

use Yii;

/**
 * This is the ActiveQuery class for [[\common\modules\news\models\NewsTag]].
 *
 * @see \common\modules\news\models\NewsTag
 */
class NewsTagQuery extends \yii\db\ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->joinWith(['translations'])->andWhere(['locale' => $locale]);
    }
}