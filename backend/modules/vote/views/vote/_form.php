<?php

use backend\forms\helpers\FieldHelper;
use backend\forms\RadiataField;
use backend\forms\widgets\LangInputWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\modules\vote\models\Vote */
/* @var $modelOption common\modules\vote\models\VoteOption */
/* @var $form yii\bootstrap\ActiveForm */
?>

    <div class="vote-form">

        <?php $form = ActiveForm::begin([
            'id'         => 'vote',
            'layout'     => 'horizontal',
            'fieldClass' => RadiataField::className(),
        ]); ?>

        <?= FieldHelper::showErrors($model); ?>

        <?= $form->field($model, 'title')->widget(LangInputWidget::classname(), [
            'options' => [
                'type' => 'activeTextInput',
            ],
        ]) ?>

        <?= $form->field($model, 'date_start')->dateInput(); ?>

        <?= $form->field($model, 'date_end')->dateInput(); ?>

        <?= $form->field($model, 'type')->dropDownList($model->getTypesList()); ?>

        <?= $form->field($model, 'status')->dropDownList($model->getStatusesList()); ?>

        <div class="form-group">
            <label class="control-label col-sm-3" for="vote-status"><?= Yii::t("b/vote/option", "Options"); ?></label>

            <div class="col-sm-6">
                <div>
                    <span class="btn btn-success fileinput-button" id="button-add-option"> <i class="fa fa-fw fa-plus"></i> <span><?php echo Yii::t("b/vote/option", "Add..."); ?></span></span>
                </div>
                <div class="height-20" id="deleted-options"></div>
                <div id="vote-options">
                    <?= FieldHelper::buildVoteOption($form, $modelOption, true); ?>
                    <?
                    if($model->voteOptions) {
                        foreach ($model->voteOptions as $voteOption) {
                            echo FieldHelper::buildVoteOption($form, $voteOption);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('b/vote', 'Create') : Yii::t('b/vote', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?
$jsCode = <<< 'JS'
    var voteOptionIndex = -1;
    $('#button-add-option').click(function(){
        var newOption = $("#vote-options .option-template").clone().removeClass('option-template').removeClass('hidden');
        newOption.html(function (i, oldHTML) {
            return oldHTML.replace(/NEW_IND/g, (voteOptionIndex--));
        });
        newOption.appendTo("#vote-options");

        radiata.initLangTabs();
        radiata.makeSortable('#vote-options');

        return false;
    });

    $('#vote-options').on('click', '.button-delete-option', function () {
        $(this).parents('.form-group:first').remove();
    });

    $('#vote-options').on('click', '.button-delete-option-exists', function () {
        var AreYouSure = confirm(i18n.AreYouSure);
        if(AreYouSure) {
            var input = "<input type=\"hidden\" name=\"OptionDeletedItems[]\" value=\"" + $(this).data('optionId') + "\">";
            $("#deleted-options").append(input);
            $(this).parents('.form-group:first').remove();
        }
    });

    radiata.makeSortable('#vote-options');
JS;
$this->registerJs($jsCode, View::POS_READY);
?>