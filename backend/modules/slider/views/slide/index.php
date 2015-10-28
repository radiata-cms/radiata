<?php

use common\widgets\Callout;
use himiklab\sortablegrid\SortableGridView;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\slider\models\SlideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/slider/slide', 'Slides');
?>
<div class="slider-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel, 'showSearchForm' => $showSearchForm]); ?>

    <p>
        <?= Html::a(Yii::t('b/slider/slide', 'Create Slide'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?
    $gridOptions = [];
    if(Yii::$app->request->queryParams['SlideSearch']['slider_id']) {
        $gridClass = SortableGridView::className();
        $gridOptions = ['sortableAction' => 'sortByPosition'];
    } else {
        $gridClass = GridView::className();
    }
    ?>
    <?= $gridClass::widget($gridOptions + [
            'dataProvider' => $dataProvider,
            'columns'      => [
                'title',
                [
                    'attribute' => 'slider_id',
                    'value'     => function ($model) {
                        return $model->slider->title;
                    },
                ],
                [
                    'attribute' => 'status',
                    'value'     => function ($model) {
                        return Yii::t('b/slider/slide', 'status' . $model->status);
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?= Callout::widget([
        'type'    => 'warning',
        'message' => Yii::t('b/slider/slide', 'Sort hint'),
    ]); ?>

</div>
