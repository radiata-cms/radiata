<?php

use backend\forms\RadiataField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\NewsTagSearch */
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
        <?= $form->field($model, 'name') ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/news/tag', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/news/tag', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
