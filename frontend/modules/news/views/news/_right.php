<?php
/* @var $this yii\web\View */
use frontend\modules\banner\widgets\BannerPlaceWidget;
use frontend\modules\news\widgets\NewsCategoriesWidget;
use frontend\modules\news\widgets\NewsTagsWidget;
use frontend\modules\vote\widgets\VoteWidget;

/* @var $category common\modules\news\models\NewsCategory */
?>

<aside class="col-md-4">
    <?= BannerPlaceWidget::widget(['place' => 1]); ?>
    <?= VoteWidget::widget(); ?>
    <?= NewsCategoriesWidget::widget(['parent_id' => $category->id]) ?>
    <?= NewsTagsWidget::widget() ?>
</aside>