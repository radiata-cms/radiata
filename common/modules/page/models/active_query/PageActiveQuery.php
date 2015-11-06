<?php

namespace common\modules\page\models\active_query;

use common\modules\page\models\Page;
use Yii;

/**
 * This is the ActiveQuery class for [[\common\modules\page\models\Page]].
 *
 * @see \common\modules\page\models\Page
 */
class PageActiveQuery extends \yii\db\ActiveQuery
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
        $this->andWhere(['status' => Page::STATUS_ACTIVE]);

        return $this;
    }
}