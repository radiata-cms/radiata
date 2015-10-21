<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\TextBlock */

$this->title = Yii::t('b/radiata/textblock', 'Update') . ' ' . $model->name . ($model->key ? ' / ' . $model->key : '');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-text-height"></i> ' . Yii::t('b/radiata/textblock', 'Text Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name . ($model->key ? ' / ' . $model->key : ''), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/radiata/textblock', 'Update');
?>
<div class="text-block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
