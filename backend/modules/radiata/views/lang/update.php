<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Lang */

$this->title = Yii::t('b/radiata/lang', 'Update');

$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-language"></i> ' . Yii::t('b/radiata/lang', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/radiata/lang', 'Update');

?>
<div class="lang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
