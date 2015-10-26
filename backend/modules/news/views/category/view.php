<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-cubes"></i> ' . Yii::t('b/news/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/news/category', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/news/category', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/news/category', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            [
                'label' => Yii::t('b/news/category', 'Status'),
                'value' => Yii::t('b/news/category', 'status' . $model->status),
            ],
            [
                'label' => Yii::t('b/news/category', 'Parent'),
                'value' => $model->parent->title ? $model->parent->title : Yii::t('b/radiata/common', 'ROOT'),
            ],

        ],
    ]) ?>

</div>
