<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Lang */

$this->title = Yii::t('b/radiata/lang', 'Create Lang');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-language"></i> ' . Yii::t('b/radiata/lang', 'Nav title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
