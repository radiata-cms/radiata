<?php
namespace backend\modules\radiata\widgets;

use backend\modules\radiata\controllers\UserController;
use backend\modules\radiata\components\BackendAccessControl;
use common\models\user\User;
use Yii;

class LastUsersWidget extends \yii\bootstrap\Widget
{
    public $limit = 8;

    public function run()
    {
        if(BackendAccessControl::checkPermissionAccess(UserController::BACKEND_PERMISSION)) {
            $users = User::find()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('id')
                ->limit($this->limit)
                ->all();

            if(count($users) > 0) {
                return $this->render('LastUsers', [
                    'users' => $users
                ]);
            }
        }
    }
}