<?php

/* @var $this yii\web\View */
use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $model common\modules\news\models\NewsTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-tags-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'new-tag-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className()
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'name')->widget(LangInputWidget::classname(), [
        'options' => [
            'type' => 'activeTextInput',
        ],
    ]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/news/tag', 'Create') : Yii::t('b/news/tag', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>