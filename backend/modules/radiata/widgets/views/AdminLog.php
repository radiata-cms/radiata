<?php
/* @var $this yii\web\View */
/* @var $logs backend\modules\radiata\models\AdminLog[] */

use common\modules\radiata\helpers\DateHelper;
use yii\helpers\Url;

?>
<!-- The time line -->
<? $currentDate = ''; ?>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            <?
            foreach ($logs as $log) {
                if($currentDate != Yii::$app->formatter->asDate($log['created_at'], 'medium')) {
                    $currentDate = Yii::$app->formatter->asDate($log['created_at'], 'medium');
                    ?>
                    <li class="time-label">
                        <span class="bg-red"><?= $currentDate ?></span>
                    </li>
                <? } ?>
                <li>
                    <?= $log['icon'] ? '<i class="fa ' . $log['icon'] . '"></i>' : '' ?>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?= DateHelper::getAgoDate($log['created_at']) ?></span>

                        <h3 class="timeline-header no-border">
                            <?= isset($log['additional_icon']) ? '<i class="fa ' . $log['additional_icon'] . '"></i>' : '' ?>
                            <? if(isset($log['user'])) { ?>
                                <a href="<?= Url::to(['user/view', 'id' => $log['user_id']]) ?>"><?= $log['user'] ?></a>
                            <? } ?>
                            <?= $log['action'] ?><?= $log['data'] ? ' "' . $log['data'] . '"' : '' ?>
                        </h3>
                    </div>
                </li>
            <? } ?>
            <li>
                <i class="fa fa-clock-o bg-gray"></i>
            </li>
        </ul>
    </div>
</div>