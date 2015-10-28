<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slide */

$this->title = Yii::t('b/slider/slide', 'Create Slide');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
