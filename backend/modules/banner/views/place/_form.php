<?php

use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\BannerPlace */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="banner-place-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'banner-place',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/banner/place', 'Create') : Yii::t('b/banner/place', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
