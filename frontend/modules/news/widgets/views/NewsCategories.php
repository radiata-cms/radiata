<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

/* @var common\modules\news\models\NewsCategory[] $categories */
?>
<? ?>
<div class="widget categories">
    <h3><?= Yii::t('f/news', 'Categories') ?></h3>

    <div class="row">
        <div class="col-sm-6">
            <ul class="blog_category">
                <? foreach ($categories as $category) { ?>
                    <li><?= Html::a($category->title, ['/news/category/view', 'slug' => $category->slug]) ?></li>
                <? } ?>
            </ul>
        </div>
    </div>
</div>