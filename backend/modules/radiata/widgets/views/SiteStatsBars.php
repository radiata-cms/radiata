<?php
/* @var $this yii\web\View */
?>


<? foreach ($bars as $bar) { ?>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box <?= $bar['bgClass'] ?>">
                <div class="inner">
                    <h3><?= $bar['data'] ?></h3>

                    <p><?= $bar['label'] ?></p>
                </div>
                <div class="icon"><i class="fa <?= $bar['icon'] ?>"></i></div>
                <a href="<?= $bar['url'] ?>" id="stats-bar-<?= $bar['icon'] ?>" class="small-box-footer"><?= isset($bar['more']) ? $bar['more'] : Yii::t('b/radiata/common', 'More info') ?>
                    <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    <? } ?>
