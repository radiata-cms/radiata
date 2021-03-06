<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLteAsset;
use yii\helpers\Html;

AdminLteAsset::register($this);

$this->title = Yii::t('c/radiata', 'Site name') . ' / ' . Yii::t('c/radiata', 'CMS');
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

<?= $this->render('_common/_js.php'); ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
