<?php
/**
 * Disabling expired banners
 */

use common\modules\banner\models\Banner;

class BannerStatusCommand extends ConsoleCommand
{
    public function run($args)
    {

        $criteria = new DbCriteria();

        $criteria->addCondition("date_end <> '0000-00-00'");
        $criteria->addCondition("date_end IS NOT NULL");
        $criteria->addCondition("date_end < NOW()");

        $updatedCnt = Banner::model()->updateAll(['status' => Banner::STATUS_DISABLED], $criteria);

        if($updatedCnt > 0) {
            Yii::$app->cache->clear('banner');
        }

    }
}