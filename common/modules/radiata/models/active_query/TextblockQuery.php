<?php

namespace common\modules\radiata\models\active_query;

use Yii;

/**
 * This is the ActiveQuery class for [[\common\modules\radiata\models\Textblock]].
 *
 * @see \common\modules\radiata\models\Textblock
 */
class TextblockQuery extends \yii\db\ActiveQuery
{
    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->joinWith(['translations'])->andWhere(['locale' => $locale]);
    }
}