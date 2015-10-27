<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsTag */

$this->title = Yii::t('b/news/tag', 'Update');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-tags"></i> ' . Yii::t('b/news/tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('b/news/tag', 'Update');
?>
<div class="news-tags-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
