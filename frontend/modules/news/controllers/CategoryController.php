<?php

namespace frontend\modules\news\controllers;

use common\modules\news\models\News;
use common\modules\news\models\NewsCategory;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Category controller
 */
class CategoryController extends Controller
{
    public function actionView($slug)
    {
        $category = NewsCategory::find()->active()->language()->andWhere(['slug' => $slug])->one();

        if(!$category) {
            throw new NotFoundHttpException();
        }

        $query = News::find()->active()->language()->category($category);
        $pages = new Pagination([
            'totalCount'      => $query->count(),
            'defaultPageSize' => Yii::t('f/news', 'defaultPageSize'),
            'forcePageParam'  => false,
        ]);
        $news = $query->order()->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('view', ['category' => $category, 'news' => $news, 'pages' => $pages]);
    }
}