<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">
    
    <?php $form = ActiveForm::begin([
        'id'         => 'page-form',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>
    
    <?= FieldHelper::showErrors($model); ?>
    
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#main-tab" data-toggle="tab"><?= Yii::t('b/page', 'Main tab') ?></a></li>
            <li><a href="#seo-tab" data-toggle="tab"><?= Yii::t('b/page', 'Seo tab') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="main-tab">
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
                
                <?= $form->field($model, 'description')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type' => 'activeTextarea',
                    ],
                ]) ?>
                
                <?= $form->field($model, 'content')->widget(LangInputWidget::classname(), [
                    'options' => [
                        'type'       => 'activeTextarea',
                        'redactor'   => true,
                        'urlPreffix' => 'page/',
                        'form'       => $form,
                    ],
                ]) ?>
            </div>
            <div class="tab-pane" id="seo-tab">
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
            </div>

        </div>
    </div>
    <!-- /.nav-tabs-custom -->
    
    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('b/page', 'Create') : Yii::t('b/page', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <? $this->registerJs('radiata.initErrorsInTabs("#page-form");', View::POS_READY); ?>
    <? $this->registerJs('radiata.updateWysiwygTextArea("#page-form");', View::POS_READY); ?>

</div>
