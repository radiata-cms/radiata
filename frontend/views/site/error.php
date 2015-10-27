<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<section id="error" class="container text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= nl2br(Html::encode($message)) ?></p>
    <?= Html::a(Yii::t('c/radiata', 'Go back to homepage'), ['/'], ['class' => 'btn btn-primary']) ?>
</section><!--/#error-->