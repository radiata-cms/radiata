<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\page\models\Page */

$this->title = Yii::t('b/page', 'Create Page');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
