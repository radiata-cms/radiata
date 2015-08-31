<?php
namespace backend\modules\radiata\controllers;

use Yii;
use backend\modules\radiata\components\BackendController;

class TestController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}