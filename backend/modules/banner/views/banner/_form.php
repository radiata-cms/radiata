<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\FileInputWidget;
use common\modules\banner\models\BannerPlace;
use common\modules\radiata\models\Lang;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\banner\models\Banner */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin([
        'id'         => 'banner',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
        'options'    => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= FieldHelper::showErrors($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place_id')->dropDownList(BannerPlace::getPlacesForDropDown(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

    <?= $form->field($model, 'locale')->dropDownList(Lang::getLangForDropDown(), ['prompt' => Yii::t('b/banner', 'All languages')]); ?>

    <?= $form->field($model, 'date_start')->dateInput(); ?>

    <?= $form->field($model, 'date_end')->dateInput(); ?>

    <?= $form->field($model, 'html')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->widget(FileInputWidget::classname(), [
        'options'       => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => $model->getImageFileUrl('image') ? [
                Html::img($model->getImageFileUrl('image'), ['class' => 'file-preview-image']),
            ] : [],
        ],
    ]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_wnd')->checkbox() ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesList(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/banner', 'Create') : Yii::t('b/banner', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
