<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/news', 'News tape');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel, 'modelCategory' => $modelCategory,]); ?>

    <p>
        <?= Html::a(Yii::t('b/news/news', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'date:datetime',
            [
                'label' => Yii::t('b/news', 'Category'),
                'value' => function ($model, $index, $widget) {
                    return $model->category->title;
                },
            ],
            [
                'label' => Yii::t('b/news', 'Status'),
                'value' => function ($model, $index, $widget) {
                    return Yii::t('b/news', 'status' . $model->status);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
