<?
/* @var $this \yii\web\View */

use frontend\modules\menu\widgets\NavBarWidget;

?>

<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <?= Yii::t('c/radiata', 'copyright', ['year' => date('Y')]) ?>
                <br>
                <?= Yii::powered() ?>
            </div>
            <div class="col-sm-6">
                <?= NavBarWidget::widget([
                    'menuId'  => 2,
                    'type'    => NavBarWidget::LINEAR_MENU,
                    'options' => [
                        'class' => 'pull-right',
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</footer><!--/#footer-->