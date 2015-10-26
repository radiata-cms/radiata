<?php

use backend\assets\JSTreeAsset;
use backend\forms\widgets\JSTreeWidget;
use backend\modules\radiata\widgets\TreeNavBarWidget;
use common\modules\menu\models\Menu;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('b/menu', 'Menus');

JSTreeAsset::register($this);
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel, 'modelMenu' => $modelMenu, 'showSearchForm' => $showSearchForm]); ?>

    <div class="row">
        <div class="col-md-3" style="overflow-x: auto;">
            <?= JSTreeWidget::widget() ?>
        </div>
        <div class="col-md-9">
            <p>
                <?= Html::a(Yii::t('b/menu', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(['id' => 'mainGridContainer']) ?>

            <?= TreeNavBarWidget::widget(['className' => Menu::className(), 'parent_id' => $parent_id]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    [
                        'label'  => Yii::t('b/menu', 'Status'),
                        'format' => 'raw',
                        'value'  => function ($model) {
                            return Yii::t('b/menu', 'status' . $model->status);
                        },
                    ],
                    [
                        'label'  => Yii::t('b/menu', 'Sub menus'),
                        'format' => 'raw',
                        'value'  => function ($model) {
                            return Html::a($model->getChildrenCount(), ['index', 'parent_id' => $model->id]);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>
