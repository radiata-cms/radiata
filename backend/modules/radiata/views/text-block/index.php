<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\modules\radiata\models\TextBlock */

$this->title = Yii::t('b/radiata/textblock', 'Text Blocks');
$this->params['breadcrumbs'][] = '<i class="fa fa-text-height"></i> ' . $this->title;
?>
<div class="text-block-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/textblock', 'Create Text Block'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'name',
            'key',
            'text:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
