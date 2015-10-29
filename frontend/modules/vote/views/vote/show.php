<?
/* @var yii\web\View $this */
/* @var common\modules\vote\models\Vote $vote */
?>

<div class="container">
    <div class="row">
        <div class="site-login">
            <h2><?= $vote->title ?></h2>

            <div><?= $this->render('/vote/_vote.php', compact('vote', 'options', 'isVoted', 'maxPercent')) ?></div>
        </div>
    </div>
</div>
