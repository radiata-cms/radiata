<?php

namespace common\modules\vote\models\active_query;

use Yii;

/**
 * This is the ActiveQuery class for [[\common\modules\vote\models\Vote]].
 *
 * @see \common\modules\vote\models\Vote
 */
class VoteActiveQuery extends \yii\db\ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->joinWith(['translations'])->andWhere(['locale' => $locale]);
    }
}