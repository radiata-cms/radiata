<?
/* @var $content string */
/* @var $this yii\web\View */

use backend\widgets\Breadcrumbs;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= Yii::t('c/radiata', 'Dashboard') ?></h1>
        <?= Breadcrumbs::widget(['breadcrumbs' => $this->params['breadcrumbs']]); ?>
    </section>
    <!-- Main content -->

    <section class="content"><?= $content; ?></section>
</div>
<!-- /.content-wrapper -->