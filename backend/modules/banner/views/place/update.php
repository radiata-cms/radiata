<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\BannerPlace */

$this->title = Yii::t('b/banner/place', 'Update') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-flag-o"></i> ' . Yii::t('b/banner/place', 'Banner Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/banner/place', 'Update');
?>
<div class="banner-place-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
