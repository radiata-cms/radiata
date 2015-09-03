<?
/* @var $content string */
/* @var $this yii\web\View */
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= Yii::t('c/radiata', 'Dashboard') ?></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?= Yii::t('c/radiata', 'Dashboard') ?></a></li>
            <li class="active">Module</li>
        </ol>
    </section>
    <!-- Main content -->

    <?= $content; ?>
</div>
<!-- /.content-wrapper -->