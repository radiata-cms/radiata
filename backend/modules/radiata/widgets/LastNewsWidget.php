<?php
namespace backend\modules\radiata\widgets;

use backend\modules\radiata\components\BackendAccessControl;
use backend\modules\radiata\controllers\UserController;
use common\modules\news\models\News;
use Yii;

class LastNewsWidget extends \yii\bootstrap\Widget
{
    public $limit = 4;

    public function run()
    {
        if(BackendAccessControl::checkPermissionAccess(UserController::BACKEND_PERMISSION)) {
            $news = News::find()
                ->language()
                ->orderBy(['date' => SORT_DESC])
                ->limit($this->limit)
                ->all();

            if(count($news) > 0) {
                return $this->render('LastNews', [
                    'news' => $news
                ]);
            }
        }
    }
}