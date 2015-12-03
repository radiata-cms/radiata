<?php

use himiklab\sortablegrid\SortableGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/slider/slide', 'Slides');
?>
<div class="slider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/slider/slide', 'Create Slide'), ['create', 'slider_id' => $slider_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?
    echo SortableGridView::widget([
        'sortableAction' => 'sortByPosition',
            'dataProvider' => $dataProvider,
            'columns'      => [
                'title',
                [
                    'attribute' => 'slider_id',
                    'value'     => function ($model) {
                        return $model->slider->title;
                    },
                ],
                [
                    'attribute' => 'status',
                    'value'     => function ($model) {
                        return Yii::t('b/slider/slide', 'status' . $model->status);
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
    ]);
    ?>

</div>
