<?php

use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slider */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="slider-place-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'slider-place',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/slider', 'Create') : Yii::t('b/slider', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
