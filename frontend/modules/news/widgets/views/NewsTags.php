<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

/* @var common\modules\news\models\NewsTag[] $tags */
?>
<? ?>
<div class="widget tags">
    <h3><?= Yii::t('f/news', 'Tag cloud') ?></h3>
    <ul class="tag-cloud">
        <? foreach ($tags as $tag) { ?>
            <li>
                <?= Html::a($tag->name, ['/news/tag/view', 'name' => $tag->name], ['class' => 'btn btn-xs btn-primary']) ?>
            </li>
        <? } ?>
    </ul>
</div>