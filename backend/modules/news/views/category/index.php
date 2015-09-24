<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/news/category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/news/category', 'Create News Category'), ['create', 'parent_id' => $parent_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'title',
            'slug',
            [
                'label'  => Yii::t('b/news/category', 'Status'),
                'format' => 'raw',
                'value'  => function ($model, $index, $widget) {
                    return Yii::t('b/news/category', 'status' . $model->status);
                },
            ],
            [
                'label'  => Yii::t('b/news/category', 'Subcategories'),
                'format' => 'raw',
                'value'  => function ($model, $index, $widget) {
                    return Html::a($model->getChildrenCount(), ['index', 'parent_id' => $model->id]);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
