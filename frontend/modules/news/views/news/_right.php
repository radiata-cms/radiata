<?php
/* @var $this yii\web\View */
use frontend\modules\news\widgets\NewsCategoriesWidget;
use frontend\modules\news\widgets\NewsTagsWidget;

/* @var $category common\modules\news\models\NewsCategory */
?>

<aside class="col-md-4">
    <?= NewsCategoriesWidget::widget(['parent_id' => $category->id]) ?>
    <?= NewsTagsWidget::widget() ?>
</aside>