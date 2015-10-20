<?php
use backend\modules\radiata\widgets\AdminLogWidget;
use backend\modules\radiata\widgets\LastNewsWidget;
use backend\modules\radiata\widgets\LastUsersWidget;
use backend\modules\radiata\widgets\SiteStatsBarsWidget;
use common\widgets\Alert;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<?= Alert::widget(); ?>

<?= SiteStatsBarsWidget::widget(); ?>

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
            <div class="row">
                <?= LastUsersWidget::widget() ?>
                <?= LastNewsWidget::widget() ?>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

<?= AdminLogWidget::widget() ?>