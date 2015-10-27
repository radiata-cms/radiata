<?php

/* @var $this yii\web\View */
use frontend\modules\radiata\widgets\MetaTagsWidget;

/* @var $tag common\modules\news\models\NewsTag */

$this->title = $tag->name;
$this->params['breadcrumbs'][] = Yii::t('c/news', 'Tags');
$this->params['breadcrumbs'][] = $tag->name;

MetaTagsWidget::widget(['type' => 'tag', 'item' => $tag]);
?>

<section class="container">
    <div class="center">
        <h2><?= $tag->name ?></h2>
    </div>
</section>