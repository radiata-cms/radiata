<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\vote\models\Vote */
/* @var $modelOption common\modules\vote\models\VoteOption */

$this->title = Yii::t('b/vote', 'Update') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/vote', 'Update');
?>
<div class="vote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'modelOption' => $modelOption,
    ]) ?>

</div>
