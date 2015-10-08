<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-bars"></i> ' . Yii::t('b/news', 'News tape'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/news/news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/news/news', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/news/news', 'Are you sure you want to delete this item?'),
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
            'date:datetime',
            [
                'label' => Yii::t('b/news', 'Category'),
                'value' => $model->category->title,
            ],
            [
                'label' => Yii::t('b/news', 'Status'),
                'value' => Yii::t('b/news', 'status' . $model->status),
            ],
            [
                'label'  => Yii::t('b/news', 'Image'),
                'format' => 'raw',
                'value'  => $model->getThumbFileUrl('image', 'small') ? Html::img($model->getThumbFileUrl('image', 'small')) : null,
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
