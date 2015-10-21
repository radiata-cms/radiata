<?
use yii\helpers\Html;

?>
<div id="languages">
    <ul class="list-inline">
        <li><?= Yii::t('c/radiata', 'Choose lang') ?>:</li>
        <? foreach ($languages as $lang) { ?>
            <li>
                <i class="iconflags iconflags-<?= $lang->code ?>"></i>
                <? if($current->code == $lang->code) { ?>
                    <b><?= $lang->code ?></b>
                <? } else { ?>
                    <?= Html::a($lang->code, $lang->getLink()) ?>
                <? } ?>
            </li>
        <? } ?>
    </ul>
</div>