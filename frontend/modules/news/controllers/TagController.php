<?php

namespace frontend\modules\news\controllers;

use common\modules\news\models\News;
use common\modules\news\models\NewsTag;
use Yii;
use yii\data\Pagination;
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

        $query = News::find()->active()->language()->tag($tag);
        $pages = new Pagination([
            'totalCount'      => $query->count(),
            'defaultPageSize' => Yii::t('f/news', 'defaultPageSize'),
            'forcePageParam'  => false,
        ]);
        $news = $query->order()->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('view', ['tag' => $tag, 'news' => $news, 'pages' => $pages]);
    }
}