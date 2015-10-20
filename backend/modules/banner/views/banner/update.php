<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\Banner */

$this->title = Yii::t('b/banner', 'Update') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/banner', 'Update');
?>
<div class="banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
