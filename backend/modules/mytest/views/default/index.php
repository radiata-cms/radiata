<?
/* @var $this \yii\web\View */
/* @var $time string */

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'test';

?>

<section class="content">

    <?= Url::to(['default/index']) ?><br><?= date('H:i:s') ?><br>

    <?= Url::to(['/radiata/radiata/login', 'id' => 5]) ?><br><?= date('H:i:s') ?><br>

    <?php Pjax::begin(['id' => 'refresh']); ?>
    <?= Html::a("Refresh", ['default/index'], ['class' => 'btn btn-lg btn-primary']) ?>
    <h1>Current time: <?= $time ?></h1>
    <?php Pjax::end(); ?>

</section>