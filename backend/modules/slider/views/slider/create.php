<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slider */

$this->title = Yii::t('b/slider', 'Create Slider');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-place-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
