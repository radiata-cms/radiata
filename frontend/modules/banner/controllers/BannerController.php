<?php

namespace frontend\modules\banner\controllers;

use common\modules\banner\models\Banner;
use common\modules\radiata\helpers\CacheHelper;
use Yii;
use yii\base\Exception;
use yii\web\Controller;

/**
 * Banner controller
 */
class BannerController extends Controller
{

    public function actionDisableExpiredBanners()
    {

        if(Yii::$app->request->userIP == '127.0.0.1') {
            $updatedCnt = Banner::updateAll(
                ['status' => Banner::STATUS_DISABLED],
                "date_end > 0 AND date_end < " . time()
            );

            if($updatedCnt > 0) {
                CacheHelper::delete('Banner');
            }
        }
    }

    public function actionClick($id)
    {
        $banner = Banner::find()->language()->active()->where(['id' => $id])->with('stat')->one();

        if($banner && $banner->link) {
            $banner->addClick();

            return $this->redirect($banner->link);
        } else {
            throw new Exception('Banner not found!');
        }
    }
}