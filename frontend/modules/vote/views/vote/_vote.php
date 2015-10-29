<?
/* @var yii\web\View $this */
/* @var common\modules\vote\models\Vote $vote */
/* @var common\modules\vote\models\VoteOption[] $options */
/* @var boolean $isVoted */
/* @var boolean $skipContainer */
/* @var float $maxPercent */

use common\modules\vote\models\Vote;
use frontend\modules\vote\assets\VoteAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

VoteAsset::register($this);
?>

<? if($isVoted) { ?>
    <? if(!empty($options)) { ?>
        <? foreach ($options as $option) { ?>
            <div class="vote-option-block">
                <span><?= $option->percent ?>%</span> <?= $option->title ?>
                <div class="vote-bar" style="width: <?= ($option->percent > 0 ? round($option->percent * 100 / $maxPercent, 2) : '1px'); ?>;"></div>
            </div>
        <? } ?>
    <? } ?>
    <div class="vote-option-total"><?= Yii::t('f/vote', 'Total votes:') ?> <span><?= $vote->total_votes ?></span></div>
<? } else { ?>
    <? if(!empty($options)) { ?>
        <div class="vote-error"></div>
        <? if($vote->type == Vote::TYPE_SINGLE) { ?>
            <?= Html::radioList('vote', '', $options, ['class' => 'vote-input']) ?>
        <? } elseif($vote->type == Vote::TYPE_MULTI) { ?>
            <?= Html::checkboxList('vote', '', $options, ['class' => 'vote-input']) ?>
        <? } ?>
        <div><?= Html::button(Yii::t('f/vote', 'Do vote'), ['id' => 'vote-send-btn', 'class' => 'btn']) ?></div>
        <div><?= Html::a(Yii::t('f/vote', 'Results'), ['/vote/vote/show', 'id' => $vote->id], ['target' => '_blank', 'class' => 'vote-results-lnk']) ?></div>
        <?
        $jsCode = new JsExpression("
                var voteObj = {};
                voteObj.url = '" . Url::to(['/vote/vote/answer']) . "';
                voteObj.lang = {
                    'errors': {
                        'required': '" . Yii::t('f/vote', 'Please check your answer') . "',
                        'failed': '" . Yii::t('f/vote', 'Request failed. Please try again') . "'
                    }
                }");
        $this->registerJs($jsCode, View::POS_END);
        ?>
    <? } ?>
<? } ?>