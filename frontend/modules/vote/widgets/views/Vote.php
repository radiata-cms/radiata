<?
/* @var yii\web\View $this */
/* @var common\modules\vote\models\Vote $vote */
?>

<div class="vote-block">
    <h4><?= Yii::t('f/vote', 'Votes') ?></h4>
    <h5><?= $vote->title ?></h5>

    <div id="vote-block-container">
        <?= $this->render('@app/modules/vote/views/vote/_vote.php', compact('vote', 'options', 'isVoted', 'maxPercent')) ?>
    </div>
</div>
