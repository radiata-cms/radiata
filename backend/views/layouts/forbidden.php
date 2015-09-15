<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\AdminLteAsset;

AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="login-box">
    <div class="login-logo">
        <b><?= Yii::t('c/radiata', 'CMS') ?></b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?= $content ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php $this->endBody() ?>

<? echo $this->render('_common/_icheck.php'); ?>

</body>
</html>
<?php $this->endPage() ?>
