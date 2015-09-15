<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\user\User $model
 */

$this->title = Yii::t('b/radiata/user', 'Create {modelClass}', ['modelClass' => 'User']);
$this->params['breadcrumbs'][] = '<i class="fa fa-users"></i> ' . $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
