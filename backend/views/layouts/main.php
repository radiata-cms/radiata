<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\assets\AdminLteAsset;
use backend\modules\radiata\widgets\I18nSettingsWidget;

AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);

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

<div class="lockscreen-container"
     data-url="<?= Url::to(['/radiata/radiata/lock-screen', 'id' => Yii::$app->user->id]); ?>"></div>
<?php Pjax::begin(['id' => 'pjax_container']); ?><?php Pjax::end(); ?>

<script type="application/javascript"><?= I18nSettingsWidget::widget() ?></script>

<?php $this->endBody() ?>

<? echo $this->render('_common/_icheck.php'); ?>

</body>
</html>
<?php $this->endPage() ?>
