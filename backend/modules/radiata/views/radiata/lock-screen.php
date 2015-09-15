<?php
/* @var $this \yii\web\View */
/* @var $user common\models\user\User */
/* @var $successLogin boolean */

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\widgets\Errors;

?>

<!-- Automatic element centering -->
<div class="lockscreen lockscreen-wrapper">
    <div class="lockscreen-logo">
        <b><?= Yii::t('c/radiata', 'CMS') ?></b>
    </div>

    <?php Pjax::begin(['id' => 'login_form', 'enablePushState' => false]); ?>

    <? if ($successLogin) { ?>

        <?php
        $this->registerJs('$("div.lockscreen-container").html("").hide();');
        ?>

    <? } else { ?>
        <?php echo Errors::widget(['models' => [$model], 'errorClass' => 'lockscreen-errors']); ?>

        <!-- User name -->
        <div class="lockscreen-name"><?= $user->first_name . ' ' . $user->last_name ?></div>
        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="/img/lte-admin/user1-128x128.jpg" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true, 'class' => 'lockscreen-credentials', 'autocomplete' => 'off']]); ?>
            <div class="input-group">
                <?= Html::activeHiddenInput($model, 'user_id', ['value' => $user->id]); ?>

                <?= Html::activePasswordInput($model, 'user_password', ['class' => 'form-control', 'placeholder' => 'password', 'autocomplete' => 'off']); ?>

                <div class="input-group-btn">
                    <?= Html::submitButton('<i class="fa fa-arrow-right text-muted"></i>', ['class' => 'btn']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <!-- /.lockscreen credentials -->
        </div>
        <!-- /.lockscreen-item -->
    <? } ?>

    <?php Pjax::end(); ?>

    <div class="help-block text-center">
        <?= Yii::t('b/radiata/login', 'Enter lockscreen password') ?>
    </div>
    <div class="text-center">
        <a href="<?= Url::to(['radiata/login']) ?>"><?= Yii::t('b/radiata/login', 'Or sign in as a different user') ?></a>
    </div>
    <div class="lockscreen-footer text-center"></div>
</div><!-- /.center -->

