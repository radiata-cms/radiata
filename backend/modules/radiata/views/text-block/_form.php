<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\radiata\models\TextBlock */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="text-block-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'news-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextarea',
        ],
    ]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/radiata/textblock', 'Create') : Yii::t('b/radiata/textblock', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
