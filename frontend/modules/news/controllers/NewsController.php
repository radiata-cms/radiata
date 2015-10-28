<?php

namespace frontend\modules\news\controllers;

use common\modules\news\models\News;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * News controller
 */
class NewsController extends Controller
{
    public function actionView($slug)
    {
        $news = News::find()->active()->language()->andWhere(['slug' => $slug])->one();

        if(!$news) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', ['news' => $news]);
    }
}