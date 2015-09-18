<?php
namespace backend\modules\radiata\widgets;

use backend\modules\radiata\components\BackendAccessControl;
use backend\modules\radiata\controllers\AdminLogController;
use backend\modules\radiata\helpers\RadiataHelper;
use backend\modules\radiata\models\AdminLog;
use Yii;

class AdminLogWidget extends \yii\bootstrap\Widget
{
    public $limit = 20;

    public function run()
    {
        if(BackendAccessControl::checkPermissionAccess(AdminLogController::BACKEND_PERMISSION)) {
            $logs = AdminLog::find()
                ->joinWith('user')
                ->orderBy(['id' => SORT_DESC])
                ->limit($this->limit)
                ->all();

            $logsFull = [];

            if($logs) {
                $prevIcon = '';
                foreach ($logs as $log) {
                    $logFull['additional_icon'] = RadiataHelper::getActionAdditionalIconClass($log['action']);

                    $logFull['action'] = RadiataHelper::getActionName($log['action']);

                    if($log['user_id'] > 0) {
                        $logFull['user'] = $log['user']->getFullName();
                    }
                    if($prevIcon != $log['icon']) {
                        $logFull['icon'] = $log['icon'];
                        $prevIcon = $log['icon'];
                    } else {
                        $logFull['icon'] = '';
                    }
                    $logFull['data'] = $log['data'];
                    $logFull['created_at'] = $log['created_at'];
                    $logFull['user_id'] = $log['user_id'];

                    $logsFull[] = $logFull;
                }
            }

            if(count($logsFull) > 0) {
                return $this->render('AdminLog', [
                    'logs' => $logsFull
                ]);
            }
        }
    }
}