<?php

use backend\forms\RadiataField;
use common\modules\banner\models\BannerPlace;
use common\modules\radiata\models\Lang;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\banner\models\BannerSearch */
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

        <?= $form->field($model, 'locale')->dropDownList(Lang::getLangForDropDown(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

        <?= $form->field($model, 'place_id')->dropDownList(BannerPlace::getPlacesForDropDown(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

        <?= $form->field($model, 'date_start')->dateInput(); ?>

        <?= $form->field($model, 'date_end')->dateInput(); ?>

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'status')->dropDownList($model->getStatusesList(), ['prompt' => Yii::t('b/radiata/forms', 'Choose value')]); ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('b/banner', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('b/banner', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
