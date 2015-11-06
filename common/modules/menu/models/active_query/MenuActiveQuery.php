<?php

namespace common\modules\menu\models\active_query;

use common\modules\menu\models\Menu;
use Yii;

/**
 * This is the ActiveQuery class for [[\common\modules\menu\models\Menu]].
 *
 * @see \common\modules\menu\models\Menu
 */
class MenuActiveQuery extends \yii\db\ActiveQuery
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
        $this->andWhere(['status' => Menu::STATUS_ACTIVE]);

        return $this;
    }

}