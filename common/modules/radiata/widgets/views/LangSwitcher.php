<?
use yii\helpers\Html;

?>
<div id="languages">
    <ul class="list-inline">
        <? foreach ($languages as $lang) { ?>
            <li>
                <? if($current->code != $lang->code) { ?>
                    <i class="iconflags iconflags-<?= $lang->code ?>"></i>
                    <?= Html::a($lang->code, $lang->getLink()) ?>
                <? } ?>
            </li>
        <? } ?>
    </ul>
</div>