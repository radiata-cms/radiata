<?php
namespace backend\modules\mytest\controllers;

use Yii;
use backend\modules\radiata\components\BackendController;
use backend\modules\radiata\models\AdminLog;

class SiteController extends BackendController
{
    public function actionIndex()
    {
        $lang = \common\modules\radiata\models\Lang::findOne(1);
        $lang->name = 'English';
        $lang->save();

        echo 'OK';
    }
}