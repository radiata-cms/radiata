<?php
namespace backend\modules\radiata\widgets;

use backend\modules\news\controllers\NewsController;
use backend\modules\radiata\components\BackendAccessControl;
use backend\modules\radiata\controllers\UserController;
use common\models\user\User;
use common\modules\news\models\News;
use common\modules\radiata\components\Migrator;
use Yii;
use yii\helpers\Url;

class SiteStatsBarsWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $bars = [];

        if(BackendAccessControl::checkPermissionAccess(UserController::BACKEND_PERMISSION)) {
            $usersCount = User::find()->where(['status' => User::STATUS_ACTIVE])->count();
            $bars[] = [
                'bgClass' => 'bg-blue',
                'label'   => Yii::t('b/radiata/common', 'Total users'),
                'data'    => $usersCount,
                'icon'    => 'fa-user',
                'url'     => Url::to(['user/index']),
            ];
        }

        if(BackendAccessControl::checkPermissionAccess(NewsController::BACKEND_PERMISSION)) {
            $newsCount = News::find()->count();
            $bars[] = [
                'bgClass' => 'bg-olive',
                'label'   => Yii::t('b/news', 'Total news'),
                'data'    => $newsCount,
                'icon'    => 'fa-bars',
                'url'     => Url::to(['/news/news/index']),
            ];
        }

        if(BackendAccessControl::checkRoleAccess('developer')) {
            $migrator = new Migrator();
            $migrations = $migrator->findNewMigrations();
            if(count($migrations) > 0) {
                $bars[] = [
                    'bgClass' => 'bg-orange',
                    'label'   => Yii::t('b/radiata/common', 'New migrations'),
                    'data'    => count($migrations),
                    'icon'    => 'fa-database',
                    'url'     => Url::to(['radiata/apply-migrations']),
                    'more'    => Yii::t('b/radiata/common', 'Apply migrations'),
                ];
            }
        }

        if(count($bars) > 0) {
            return $this->render('SiteStatsBars', [
                'bars' => $bars
            ]);
        }
    }
}