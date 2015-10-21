<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\vote\models\Vote */
/* @var $modelOption common\modules\vote\models\VoteOption */

$this->title = Yii::t('b/vote', 'Create Vote');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'modelOption' => $modelOption,
    ]) ?>

</div>
