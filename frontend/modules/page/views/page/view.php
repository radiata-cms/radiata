<?php

/* @var $this yii\web\View */
use frontend\modules\radiata\widgets\MetaTagsWidget;

/* @var $page common\modules\page\models\Page */

$this->title = $page->title;
$this->params['breadcrumbs'][] = $page->title;

MetaTagsWidget::widget(['item' => $page]);
?>

<section>
    <div class="container">
        <div class="center wow fadeInDown">
            <h2><?= $page->title ?></h2>
        </div>
        <div class="clearfix">
            <div class="wow fadeInDown">
                <p class="lead"><?= $page->description ?></p>
                <?= $page->content ?>
            </div>
        </div>
    </div>
</section>