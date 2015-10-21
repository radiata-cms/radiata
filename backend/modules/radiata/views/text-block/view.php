<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\TextBlock */

$this->title = $model->name . ($model->key ? ' / ' . $model->key : '');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-text-height"></i> ' . Yii::t('b/radiata/textblock', 'Text Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/textblock', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/radiata/textblock', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/radiata/textblock', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'name',
            'key',
            'text:ntext',
        ],
    ]) ?>

</div>
