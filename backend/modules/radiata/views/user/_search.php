<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\forms\RadiataField;

/**
 * @var yii\web\View $this
 * @var common\models\user\UserSearch $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="box box-primary collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('b/radiata/forms', 'Detailed search form') ?></h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>
    <div class="box-body">
        <?= $form->field($model, 'first_name') ?>

        <?= $form->field($model, 'last_name') ?>

        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'created_at')->dateRangeInput(['class' => 'pull-right']) ?>

        <?= $form->field($model, 'status')->dropDownList($model->getStatusesList(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/radiata/user', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/radiata/user', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
