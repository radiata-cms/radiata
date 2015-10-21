<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\vote\models\VoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/vote', 'Votes');
?>
<div class="vote-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel, 'showSearchForm' => $showSearchForm]); ?>

    <p>
        <?= Html::a(Yii::t('b/vote', 'Create Vote'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'title',
            [
                'attribute' => 'date_start',
                'value'     => function ($model) {
                    return $model->date_start ? $model->date_start : Yii::t('app', '(not set)');
                }
            ],
            [
                'attribute' => 'date_end',
                'value'     => function ($model) {
                    return $model->date_end ? $model->date_end : Yii::t('app', '(not set)');
                }
            ],
            [
                'label' => Yii::t('b/vote', 'Status'),
                'value' => function ($model) {
                    return Yii::t('b/vote', 'status' . $model->status);
                }
            ],
            'total_answers',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
