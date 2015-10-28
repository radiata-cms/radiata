<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slide */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/slider/slide', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/slider/slide', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/slider/slide', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'slider_id',
                'value'     => $model->slider->title,
            ],
            'title',
            'description',
            [
                'label'  => Yii::t('b/slider/slide', 'Image'),
                'format' => 'raw',
                'value'  => $model->getThumbFileUrl('image', 'slide') ? Html::img($model->getThumbFileUrl('image', 'slide')) : null,
            ],
            'link',
            [
                'label' => Yii::t('b/slider/slide', 'Status'),
                'value' => Yii::t('b/slider/slide', 'status' . $model->status),
            ],
        ],
    ]) ?>

</div>
