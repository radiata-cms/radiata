<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-category-form">

    <?php $form = ActiveForm::begin([
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'title')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'slug')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesList()); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($model->getItemsForDropDownList(), ['encodeSpaces' => true]) ?>

    <?= $form->field($model, 'meta_title')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'meta_keywords')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'meta_description')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextarea',
        ],
    ]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/news/category', 'Create') : Yii::t('b/news/category', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
