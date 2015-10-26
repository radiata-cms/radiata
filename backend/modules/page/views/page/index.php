<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/page', 'Pages');
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel, 'showSearchForm' => $showSearchForm]); ?>

    <p>
        <?= Html::a(Yii::t('b/page', 'Create Page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'title',
            [
                'label' => Yii::t('b/page', 'Status'),
                'value' => function ($model, $index, $widget) {
                    return Yii::t('b/page', 'status' . $model->status);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
