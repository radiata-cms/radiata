<?php

use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\MenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary<? if(!$showSearchForm) { ?> collapsed-box<? } ?>">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('b/radiata/forms', 'Detailed search form') ?></h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'action'     => ['index'],
        'method'     => 'get',
        'layout'     => 'horizontal',
        'fieldClass' => RadiataField::className(),
    ]); ?>

    <div class="box-body">
        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'parent_id')->dropDownList($modelMenu->getItemsForLinkedField(), ['encodeSpaces' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList($model->getStatusesList(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/menu', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/menu', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
