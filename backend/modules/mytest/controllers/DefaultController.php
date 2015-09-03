<?php
namespace backend\modules\mytest\controllers;

use Yii;
use backend\modules\radiata\components\BackendController;

class DefaultController extends BackendController
{
    public function actionIndex()
    {
        return $this->render('index', ['time' => date('H:i:s')]);
    }
}