<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\Banner */

$this->title = Yii::t('b/banner', 'Create Banner');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
