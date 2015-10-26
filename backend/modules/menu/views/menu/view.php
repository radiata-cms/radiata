<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/menu', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/menu', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/menu', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'title',
            'link',
            [
                'label' => Yii::t('b/menu', 'Status'),
                'value' => Yii::t('b/menu', 'status' . $model->status),
            ],
            [
                'label' => Yii::t('b/menu', 'Parent'),
                'value' => $model->parent->title ? $model->parent->title : Yii::t('b/radiata/common', 'ROOT'),
            ],
        ],
    ]) ?>

</div>
