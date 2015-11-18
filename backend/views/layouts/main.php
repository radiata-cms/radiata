<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\widgets\Pjax;

AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);
JuiAsset::register($this);

$this->title = Yii::t('c/radiata', 'Site name') . ' / ' . Yii::t('c/radiata', 'CMS');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-<?= AdminLteAsset::ADMIN_LTE_SKIN ?> sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
    <? echo $this->render('_main/_header.php'); ?>
    <? echo $this->render('_main/_left.php'); ?>
    <? echo $this->render('_main/_center.php', ['content' => $content]); ?>
    <? echo $this->render('_main/_footer.php'); ?>
</div>

<div class="lockscreen-container" data-url="<?= Url::to(['/radiata/radiata/lock-screen', 'id' => Yii::$app->user->id]); ?>"></div>
<?php Pjax::begin(['id' => 'pjax_container']); ?><?php Pjax::end(); ?>

<?= $this->render('_common/_js.php'); ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
