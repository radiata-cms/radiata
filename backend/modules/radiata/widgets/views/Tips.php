<?php
/* @var $this yii\web\View */
/* @var $tips string[] */
use yii\web\View;

?>

<div class="hidden-xs">
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <? foreach ($tips as $key => $tip) { ?>
                <div class="item<?= $key == 0 ? ' active' : '' ?>"><b><?= Yii::t('b/radiata/common', 'Tip') ?>
                        :</b> <?= $tip; ?></div>
            <? } ?>
        </div>
    </div>
</div>
<? $this->registerJs('$(".carousel").carousel({"interval": 10000});', View::POS_READY); ?>
