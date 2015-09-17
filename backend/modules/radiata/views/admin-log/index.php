<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\radiata\helpers\RadiataHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\radiata\models\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/radiata/admin-log', 'Admin Log');
$this->params['breadcrumbs'][] = '<i class="fa fa-history"></i> ' . $this->title;
?>
<div class="admin-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            [
                'label'  => '',
                'format' => 'raw',
                'value'  => function ($model) {
                    return Html::tag('i', '', ['class' => 'grid-icon fa ' . $model->icon]);
                },
            ],
            [
                'label'         => Yii::t('b/radiata/admin-log', 'User ID'),
                'attribute'     => 'user_id',
                'enableSorting' => false,
                'format'        => 'raw',
                'value'         => function ($model) {
                    return $model->user->getFullName();
                },
            ],
            [
                'label'  => Yii::t('b/radiata/admin-log', 'Action'),
                'format' => 'raw',
                'value'  => function ($model) {
                    return Html::tag('i', '', ['class' => 'fa ' . RadiataHelper::getActionAdditionalIconClass($model->action)]) . ' ' . RadiataHelper::getActionName($model->action);
                },
            ],
            [
                'attribute'     => 'data',
                'enableSorting' => false,
                'format'        => 'ntext',
            ],
            [
                'attribute'     => 'created_at',
                'enableSorting' => false,
                'format'        => 'datetime',
            ],
        ],
    ]); ?>

</div>
