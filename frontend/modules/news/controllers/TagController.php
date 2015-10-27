<?php

namespace frontend\modules\news\controllers;

use common\modules\news\models\NewsTag;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Tag controller
 */
class TagController extends Controller
{
    public function actionView($name)
    {
        $tag = NewsTag::find()->language()->andWhere(['name' => $name])->one();

        if(!$tag) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', ['tag' => $tag]);
    }
}