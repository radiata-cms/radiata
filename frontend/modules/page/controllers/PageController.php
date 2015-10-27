<?php

namespace frontend\modules\page\controllers;

use common\modules\page\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Page controller
 */
class PageController extends Controller
{

    public function actionView($slug)
    {
        $page = Page::find()->language()->andWhere(['slug' => $slug])->one();
        if(!$page) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', ['page' => $page]);
    }
}