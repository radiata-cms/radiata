<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'news-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'title')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'link')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesList()); ?>

    <?= $form->field($model, 'parent_id')->dropDownList($model->getItemsForDropDownList(), ['encodeSpaces' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/menu', 'Create') : Yii::t('b/menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
