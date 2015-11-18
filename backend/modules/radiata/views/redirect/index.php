<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\modules\radiata\models\Redirect */

$this->title = Yii::t('b/radiata/redirect', 'Redirects');
$this->params['breadcrumbs'][] = '<i class="fa fa-exchange"></i> ' . $this->title;
?>
<div class="text-block-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/redirect', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'old_url',
            'new_url',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
