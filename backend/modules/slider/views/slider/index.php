<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/slider', 'Sliders');
?>
<div class="slider-place-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/slider', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'id',
            'title',
            [
                'label'  => Yii::t('b/slider', 'Slides'),
                'format' => 'raw',
                'value'  => function ($model, $index, $widget) {
                    return Html::a(count($model->slides), ['/slider/slide/index', 'slider_id' => $model->id]);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
