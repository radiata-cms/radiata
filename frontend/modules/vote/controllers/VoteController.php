<?php

namespace frontend\modules\vote\controllers;

use common\modules\radiata\helpers\CacheHelper;
use common\modules\vote\models\Vote;
use Yii;
use yii\web\Controller;

/**
 * Vote controller
 */
class VoteController extends Controller
{

    public function actionDisableExpiredVotes()
    {

        if(Yii::$app->request->userIP == '127.0.0.1') {
            $updatedCnt = Vote::updateAll(
                ['status' => Vote::STATUS_DISABLED],
                "date_end > 0 AND date_end < " . time()
            );

            if($updatedCnt > 0) {
                CacheHelper::delete('Vote');
            }
        }
    }
}