<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\FileInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\user\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout'  => 'horizontal',
        'fieldClass' => RadiataField::className(),
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'first_name')->textInput() ?>

    <?= $form->field($model, 'last_name')->textInput() ?>

    <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput() ?>

    <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput() ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>

    <?= $form->field($model, 'new_password_again')->passwordInput() ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesList(), ['prompt' => Yii::t('b/radiata/user', 'Choose value')]); ?>

    <?= $form->field($model, 'image')->widget(FileInputWidget::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => $model->getThumbFileUrl('image', 'avatar') ? [
                Html::img($model->getThumbFileUrl('image', 'avatar'), ['class' => 'file-preview-image']),
            ] : [],
        ],
    ]) ?>

    <?= $form->field($model, 'roles')->userRolesInput() ?>

    <?= $form->field($model, 'permissions')->userPermissionsInput() ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/radiata/user', 'Create') : Yii::t('b/radiata/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php

    $jsCode = <<< 'JS'
        $(function () {
            checkPermissionsVisibility();
            $('input[name="User[roles][manager]"]').next().on("click", function(){
                checkPermissionsVisibility();
            });

            function checkPermissionsVisibility() {
                if($('input[name="User[roles][manager]"]').is(':checked')) {
                    $('.form-group.field-user-permissions').show();
                } else {
                    $('.form-group.field-user-permissions').hide();
                }
            }
        });
JS;
    $this->registerJs($jsCode);
    ?>
</div>
