<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/banner/place', 'Banner Places');
$this->params['breadcrumbs'][] = '<i class="fa fa-flag-o"></i> ' . $this->title;
?>
<div class="banner-place-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/banner/place', 'Create Banner Place'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            'id',
            'title',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
