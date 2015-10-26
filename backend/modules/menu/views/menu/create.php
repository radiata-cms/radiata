<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */

$this->title = Yii::t('b/menu', 'Create Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
