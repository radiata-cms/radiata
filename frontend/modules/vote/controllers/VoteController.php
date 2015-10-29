<?php

namespace frontend\modules\vote\controllers;

use common\modules\radiata\helpers\CacheHelper;
use common\modules\vote\models\Vote;
use common\modules\vote\models\VoteLog;
use common\modules\vote\models\VoteOption;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Vote controller
 */
class VoteController extends Controller
{
    public function actionAnswer()
    {
        if(Yii::$app->request->isAjax && ($data = Yii::$app->request->post('vote')) !== null) {
            $options = VoteOption::find()->where(['in', 'id', array_keys(Yii::$app->request->post('vote'))])->all();
            if(empty($options)) {
                throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
            }

            $voteId = false;
            foreach ($options as $option) {
                /** var VoteOption $option  */
                if($voteId && $option->parent_id != $voteId) {
                    throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
                } elseif(!$voteId) {
                    $voteId = $option->parent_id;
                }
            }

            if(!$voteId || ($vote = Vote::find()->active()->language()->where(['id' => $voteId])->one()) === null) {
                throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
            }

            /** @var Vote $vote */
            if($vote->type == Vote::TYPE_SINGLE && count($options) > 1) {
                throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
            }

            if($vote->isVoted()) {
                throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($options as $option) {
                    $voteLog = new VoteLog();
                    $voteLog->addAnswer($voteId, $option->id);
                }
                $vote->statistics();

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();

                throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
            }

            return $this->render('_vote', ['vote' => $vote, 'options' => $vote->voteOptions, 'isVoted' => true, 'maxPercent' => $vote->getMaxPercent()]);
        } else {
            throw new BadRequestHttpException(Yii::t('f/vote', 'Request error'));
        }

    }

    public function actionShow($id)
    {
        $vote = Vote::find()->language()->active()->where(['id' => $id])->one();

        /** @var Vote $vote */
        if(!$vote) {
            throw new NotFoundHttpException(Yii::t('f/vote', 'Request error'));
        } else {
            Yii::$app->params['skipRightVote'] = true;

            return $this->render('show', ['vote' => $vote, 'options' => $vote->voteOptions, 'isVoted' => true, 'maxPercent' => $vote->getMaxPercent()]);
        }
    }

    public function actionDisableExpiredVotes()
    {
        if(Yii::$app->request->getUserIP() == '127.0.0.1') {
            $updatedCnt = Vote::updateAll(
                ['status' => Vote::STATUS_DISABLED],
                "date_end > 0 AND date_end < " . time()
            );

            if($updatedCnt > 0) {
                CacheHelper::delete(CacheHelper::getTag(Vote::className()));
            }
        }
    }
}