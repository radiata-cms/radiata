<?php

use backend\assets\JSTreeAsset;
use backend\forms\widgets\JSTreeWidget;
use backend\modules\news\widgets\CategoriesNavBarWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/news/category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

JSTreeAsset::register($this);
?>
<div class="news-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-3" style="overflow-x: auto;">
            <?= JSTreeWidget::widget() ?>
        </div>
        <div class="col-md-9">
            <p>
                <?= Html::a(Yii::t('b/news/category', 'Create News Category'), ['create', 'parent_id' => $parent_id], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(['id' => 'mainGridContainer']) ?>

            <?= CategoriesNavBarWidget::widget(['parent_id' => $parent_id]); ?>

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
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
