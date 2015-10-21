<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\vote\models\Vote */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/vote', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/vote', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/vote', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'date_start',
                'value'     => $model->date_start ? $model->date_start : Yii::t('app', '(not set)')
            ],
            [
                'attribute' => 'date_end',
                'value'     => $model->date_end ? $model->date_end : Yii::t('app', '(not set)')
            ],
            [
                'label' => Yii::t('b/vote', 'Status'),
                'value' => Yii::t('b/vote', 'status' . $model->status),
            ],
            [
                'label' => Yii::t('b/vote', 'Type'),
                'value' => Yii::t('b/vote', 'type' . $model->type),
            ],
        ],
    ]) ?>

</div>
