<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Lang */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('b/radiata/lang', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/lang', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/radiata/lang', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('b/radiata/lang', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            [
                'label'  => Yii::t('b/radiata/lang', 'Flag'),
                'format' => 'raw',
                'value'  => '<i class="iconflags iconflags-' . $model->code . '"></i>',
            ],
            'code',
            'locale',
            'name',
            [
                'attribute' => 'default',
                'format'    => 'raw',
                'value'     => $model->default ? '<i class="fa fa-check bg-green"></i>' : '',
            ],
        ],
    ]) ?>

</div>
