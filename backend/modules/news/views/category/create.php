<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\news\models\NewsCategory */

$this->title = Yii::t('b/news/category', 'Create News Category');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-cubes"></i> ' . Yii::t('b/news/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
