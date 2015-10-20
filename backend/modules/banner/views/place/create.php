<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\BannerPlace */

$this->title = Yii::t('b/banner/place', 'Create Banner Place');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-flag-o"></i> ' . Yii::t('b/banner/place', 'Banner Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-place-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
