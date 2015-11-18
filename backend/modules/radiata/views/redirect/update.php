<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Redirect */

$this->title = Yii::t('b/radiata/redirect', 'Update') . ' ' . $model->old_url;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-exchange"></i> ' . Yii::t('b/radiata/redirect', 'Text Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->old_url, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/radiata/redirect', 'Update');
?>
<div class="text-block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
