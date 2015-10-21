<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\TextBlock */

$this->title = Yii::t('b/radiata/textblock', 'Create Text Block');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-text-height"></i> ' . Yii::t('b/radiata/textblock', 'Text Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
