<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slider */

$this->title = Yii::t('b/slider', 'Update') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/slider', 'Update');
?>
<div class="slider-place-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
