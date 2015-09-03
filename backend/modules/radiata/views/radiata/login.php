<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('b/radiata/login', 'Page title');
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="login-box-msg"><?= Yii::t('b/radiata/login', 'Form title') ?></p>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="row">
    <div class="col-xs-8">
        <div class="checkbox icheck">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
    </div>
    <div class="col-xs-4">
        <?= Html::submitButton(Yii::t('b/radiata/login', 'Sign in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="social-auth-links text-center">
    <p>- <?= Yii::t('b/radiata/login', 'OR') ?> -</p>
    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i
            class="fa fa-facebook"></i> <?= Yii::t('b/radiata/login', 'Sign in using Facebook') ?></a>
</div>

<a href="<?= Yii::$app->urlManagerFrontEnd->createUrl(['user/request-password-reset']) ?>"><?= Yii::t('b/radiata/login', 'I forgot my password') ?></a>
<br>
<a href="<?= Yii::$app->urlManagerFrontEnd->createUrl(['user/signup']) ?>"
   class="text-center"><?= Yii::t('b/radiata/login', 'Register a new member') ?></a>