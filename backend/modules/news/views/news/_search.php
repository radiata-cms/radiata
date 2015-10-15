<?php

use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\NewsSearch */
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
        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'date') ?>

        <?= $form->field($model, 'category_id')->dropDownList($modelCategory->getItemsForLinkedField(), ['encodeSpaces' => true]) ?>

        <?= $form->field($model, 'status') ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/news', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/news', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
