<?php
namespace frontend\modules\vote\widgets;

use common\modules\radiata\helpers\CacheHelper;
use common\modules\vote\models\Vote;
use Yii;


class VoteWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $activeVote = $isVoted = false;

        $allVotes = Vote::getActiveVotes();
        if(!empty($allVotes)) {
            $validVotes = Vote::getValidVotes($allVotes);
            if(!empty($validVotes)) {
                $firstVote = reset($validVotes);
                foreach ($allVotes as $vote) {
                    if($vote->id == $firstVote) {
                        $activeVote = $vote;
                    }
                }
                $isVoted = false;
            } else {
                $activeVote = end($allVotes);

                $isVoted = true;
            }
        }

        if($activeVote) {
            $options = [];
            $voteOptions = CacheHelper::get(Vote::VOTE_OPTIONS_CACHE_KEY . $activeVote->id);
            if(false === $voteOptions) {
                $voteOptions = $activeVote->voteOptions;
                CacheHelper::set(Vote::VOTE_OPTIONS_CACHE_KEY . $activeVote->id, $voteOptions, CacheHelper::getTag(Vote::className()));
            }

            $maxPercent = 0;
            if(!empty($voteOptions)) {
                if($isVoted) {
                    $options = $voteOptions;
                    $maxPercent = $activeVote->getMaxPercent();
                } else {
                    foreach ($voteOptions as $option) {
                        $options[$option->id] = $option->title;
                    }
                }
            }

            return $this->render('Vote', ['vote' => $activeVote, 'options' => $options, 'isVoted' => $isVoted, 'maxPercent' => $maxPercent]);
        } else {
            return '';
        }
    }
}
