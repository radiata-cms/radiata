<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\user\User $model
 */

$this->title = Yii::t('b/radiata/user', 'Update {modelClass}: ', ['modelClass' => 'User']) . $model->id;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-users"></i> ' . Yii::t('b/radiata/user', 'Users'), 'url' => Url::to(['index'])];
$this->params['breadcrumbs'][] = ['label' => $model->first_name . ' ' . $model->last_name, 'url' => Url::to(['view', 'id' => $model->id])];
$this->params['breadcrumbs'][] = Yii::t('b/radiata/user', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
