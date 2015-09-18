<?php

use himiklab\sortablegrid\SortableGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/radiata/lang', 'Langs');
$this->params['breadcrumbs'][] = '<i class="fa fa-language"></i> ' . $this->title;
?>
<div class="lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/lang', 'Create Lang'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'LangGridViewPjax']) ?>
    <?= SortableGridView::widget([
        'id'             => 'LangGridView',
        'dataProvider'   => $dataProvider,
        'sortableAction' => 'sortByPosition',
        'columns'        => [
            'id',
            [
                'label'  => Yii::t('b/radiata/lang', 'Flag'),
                'format' => 'raw',
                'value'  => function ($model) {
                    return '<i class="iconflags iconflags-' . $model->code . '"></i>';
                }
            ],
            'code',
            'locale',
            'name',
            [
                'attribute' => 'default',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return $model->default ? '<i class="fa fa-check bg-green"></i>' : '';
                },
            ],
            'position',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
