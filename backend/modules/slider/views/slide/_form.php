<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\FileInputWidget;
use backend\forms\widgets\LangInputWidget;
use common\modules\slider\models\Slider;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\slider\models\Slide */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'slider',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
        'options'    => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'title')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'description')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextarea',
        ],
    ]) ?>

    <?= $form->field($model, 'slider_id')->dropDownList(Slider::getSlidersForDropDown(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

    <?= $form->field($model, 'image')->widget(FileInputWidget::classname(), [
        'options'       => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => $model->getThumbFileUrl('image', 'slide') ? [
                Html::img($model->getThumbFileUrl('image', 'slide'), ['class' => 'file-preview-image']),
            ] : [],
        ],
    ]) ?>

    <?= $form->field($model, 'link')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextarea',
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesList()); ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/slider/slide', 'Create') : Yii::t('b/slider/slide', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
