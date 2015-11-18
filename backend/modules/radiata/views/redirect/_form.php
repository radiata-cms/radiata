<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\Redirect */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="text-block-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'news-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'old_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/radiata/redirect', 'Create') : Yii::t('b/radiata/redirect', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
