<?
/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<? foreach ($languages as $lang) { ?>
    <li>
        <? if($current->code != $lang->code) { ?>
            <?= Html::a('<i class="iconflags iconflags-' . $lang->code . '"></i> ' . $lang->code, $lang->getLink()) ?>
        <? } ?>
    </li>
<? } ?>