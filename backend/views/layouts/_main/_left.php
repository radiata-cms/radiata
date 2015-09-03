<?php
/* @var $this yii\web\View */

use backend\widgets\ModulesBar;

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"><?= Yii::t('c/radiata', 'Navigation') ?></li>
            <?= ModulesBar::widget(['currentModule' => $this->context->module]); ?>
            <li><a href="#"><i class="fa fa-book"></i><span>Documentation</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>