<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\forms\RadiataField;
use backend\modules\radiata\models\AdminLogSearch;

/* @var $this yii\web\View */
/* @var $model backend\modules\radiata\models\AdminLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('b/radiata/forms', 'Detailed search form') ?></h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'action'     => ['index'],
        'method'     => 'get',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <div class="box-body">
        <?= $form->field($model, 'action')->dropDownList(AdminLogSearch::getActions(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

        <?= $form->field($model, 'user_id')->dropDownList(AdminLogSearch::getUsers(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

        <?= $form->field($model, 'data'); ?>

        <?= $form->field($model, 'created_at')->dateRangeInput(['class' => 'pull-right']) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/radiata/admin-log', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/radiata/admin-log', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
