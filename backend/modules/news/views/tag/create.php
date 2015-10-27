<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsTag */

$this->title = Yii::t('b/news/tag', 'Create Tag');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-tags"></i> ' . Yii::t('b/news/tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
