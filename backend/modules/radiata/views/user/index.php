<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\user\UserSearch $searchModel
 */

$this->title = Yii::t('b/radiata/user', 'Users');
$this->params['breadcrumbs'][] = '<i class="fa fa-users"></i> ' . $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('b/radiata/user', 'Create {modelClass}', ['modelClass' => 'User',]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'first_name',
            'last_name',
            'username',
            'email:email',
            [
                'label' => Yii::t('b/radiata/user', 'Avatar'),
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    return Html::img($model->getThumbFileUrl('image', 'avatar'), ['width' => '50']);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
