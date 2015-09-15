<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\user\User $model
 */

$this->title = $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = Html::a('<i class="fa fa-users"></i>' . Yii::t('b/radiata/user', 'Users'), ['index']);
$this->params['breadcrumbs'][] = '<span style="text-decoration: underline;">' . $this->title . '</span>';
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('b/radiata/user', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('b/radiata/user', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('b/radiata/user', 'Delete confirm'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
            'email:email',
            [
                'label' => Yii::t('b/radiata/user', 'Status'),
                'value' => Yii::t('b/radiata/user', 'status' . $model->status),
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'label' => Yii::t('b/radiata/user', 'Avatar'),
                'format' => 'raw',
                'value' => Html::img($model->getThumbFileUrl('image', 'avatar')),
            ],
        ],
    ]) ?>

</div>
