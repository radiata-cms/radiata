<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\banner\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/banner', 'Banners');
?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel, 'showSearchForm' => $showSearchForm]); ?>

    <p>
        <?= Html::a(Yii::t('b/banner', 'Create Banner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'id',
            [
                'attribute' => 'locale',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $model->locale ? '<i class="iconflags iconflags-' . $model->language->code . '"></i>' . $model->language->name : Yii::t('b/banner', 'All languages');
                },
            ],
            [
                'attribute' => 'place_id',
                'value'     => function ($model) {
                    return $model->place->title;
                },
            ],
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
            'title',
            [
                'attribute' => 'status',
                'value'     => function ($model) {
                    return Yii::t('b/banner', 'status' . $model->status);
                },
            ],
            [
                'label' => Yii::t('b/banner', 'Views'),
                'value' => function ($model) {
                    return $model->stat->views ? $model->stat->views : 0;
                },
            ],
            [
                'label' => Yii::t('b/banner', 'Clicks'),
                'value' => function ($model) {
                    return $model->stat->clicks ? $model->stat->clicks : 0;
                },
            ],
            [
                'label' => Yii::t('b/banner', 'CTR'),
                'value' => function ($model) {
                    return $model->stat->ctr ? $model->stat->ctr : 0;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
