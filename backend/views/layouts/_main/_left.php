<?php
/* @var $this yii\web\View */

use backend\modules\radiata\widgets\ModulesBar;

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"><?= Yii::t('c/radiata', 'Navigation') ?></li>
            <?= ModulesBar::widget(['currentModule' => $this->context->module]); ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>