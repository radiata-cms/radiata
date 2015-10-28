<?
/* @var $this \yii\web\View */
/* @var $page \common\modules\page\models\Page */
use frontend\modules\slider\widgets\SliderWidget;

?>

<?= SliderWidget::widget([
    'id'           => 'main-slider',
    'sectionClass' => 'no-margin',
    'slider_id'    => 1,
]) ?>

<? if(!empty($page)) { ?>
    <section>
        <div class="container">
            <div class="center wow fadeInDown">
                <h2><?= $page->title ?></h2>
                <?= $page->description ? '<p class="lead">' . $page->description . '</p>' : '' ?>
            </div>
            <div class="row"><?= $page->content ?></div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
<? } ?>