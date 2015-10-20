<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsTags */

$this->title = Yii::t('b/news/tags', 'Create Tag');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-tags"></i> ' . Yii::t('b/news/tags', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
