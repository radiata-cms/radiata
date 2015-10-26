<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */

$this->title = Yii::t('b/menu', 'Update');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-map-signs"></i> ' . Yii::t('b/menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/menu', 'Update');
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
