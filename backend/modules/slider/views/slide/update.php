<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slide */

$this->title = Yii::t('b/slider/slide', 'Update') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/slider/slide', 'Update');
?>
<div class="slider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
