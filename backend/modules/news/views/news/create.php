<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\news\models\News */

$this->title = Yii::t('b/news', 'Create News');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-bars"></i> ' . Yii::t('b/news', 'News tape'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'         => $model,
        'modelCategory' => $modelCategory,
    ]) ?>

</div>
