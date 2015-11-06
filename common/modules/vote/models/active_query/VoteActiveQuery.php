<?php

namespace common\modules\vote\models\active_query;

use common\modules\vote\models\Vote;
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

        return $this->innerJoinWith(['translations'])->andWhere(['locale' => $locale]);
    }

    public function active()
    {
        $this->andWhere(['status' => Vote::STATUS_ACTIVE]);

        return $this;
    }

    public function order()
    {
        $this->orderBy(['date_start' => SORT_ASC]);

        return $this;
    }
}