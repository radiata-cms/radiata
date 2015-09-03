<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?= Url::to(['/']) ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>R</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?= Yii::t('c/radiata', 'CMS') ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/lte-admin/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span
                            class="hidden-xs"><?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/img/lte-admin/user2-160x160.jpg" class="img-circle" alt="User Image">

                            <p>
                                <?= Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name ?>
                                <small><?= Yii::t('b/radiata/login', 'Member since') ?> <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at, "medium") ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= Url::to(['radiata/logout']) ?>"
                                   class="btn btn-default btn-flat"><?= Yii::t('b/radiata/login', 'Sign out') ?></a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>

                <?= backend\modules\radiata\widgets\LangSwitcherWidget::widget(); ?>

            </ul>
        </div>
    </nav>
</header>
