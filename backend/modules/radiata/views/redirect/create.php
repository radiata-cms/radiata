<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Redirect */

$this->title = Yii::t('b/radiata/redirect', 'Create');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-exchange"></i> ' . Yii::t('b/radiata/redirect', 'Redirects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
