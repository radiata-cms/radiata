<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/banner', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/banner', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/banner', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'locale',
                'format'    => 'raw',
                'value'     => $model->locale ? '<i class="iconflags iconflags-' . $model->language->code . '"></i>' . $model->language->name : Yii::t('b/banner', 'All languages'),
            ],
            [
                'attribute' => 'place_id',
                'value'     => $model->place->title,
            ],
            [
                'attribute' => 'date_start',
                'value'     => $model->date_start ? $model->date_start : Yii::t('app', '(not set)')
            ],
            [
                'attribute' => 'date_end',
                'value'     => $model->date_end ? $model->date_end : Yii::t('app', '(not set)')
            ],
            'title',
            'html:ntext',
            [
                'label'  => Yii::t('b/banner', 'Image'),
                'format' => 'raw',
                'value'  => $model->getImageFileUrl('image') ? Html::img($model->getImageFileUrl('image')) : null,
            ],
            'link',
            [
                'attribute' => 'new_wnd',
                'format'    => 'raw',
                'value'     => $model->new_wnd ? '<i class="fa fa-check bg-green"></i>' : '',
            ],
            [
                'label' => Yii::t('b/banner', 'Status'),
                'value' => Yii::t('b/banner', 'status' . $model->status),
            ],
            [
                'label' => Yii::t('b/banner', 'Views'),
                'value' => $model->stat->views ? $model->stat->views : 0,
            ],
            [
                'label' => Yii::t('b/banner', 'Clicks'),
                'value' => $model->stat->clicks ? $model->stat->clicks : 0,
            ],
            [
                'label' => Yii::t('b/banner', 'CTR'),
                'value' => $model->stat->ctr ? $model->stat->ctr : 0,
            ],

            'priority',
        ],
    ]) ?>

</div>
