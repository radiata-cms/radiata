<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\NewsTagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/news/tags', 'Tags');
$this->params['breadcrumbs'][] = '<i class="fa fa-tags"></i> ' . $this->title;
?>
<div class="news-tags-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel, 'showSearchForm' => $showSearchForm]); ?>

    <p>
        <?= Html::a(Yii::t('b/news/tags', 'Create Tag'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'id',
            'name',
            'frequency',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
