<?
/* @var $this \yii\web\View */
/* @var string[] $menuItems */
/* @var array $options */
/* @var integer $type */

use frontend\modules\menu\widgets\NavBarWidget;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Menu;

switch ($type) {
    case NavBarWidget::BOOTSTRAP_NAVBAR:
        NavBar::begin([
            'brandLabel' => Html::img('/images/logo.png', ['alt' => Yii::t('c/radiata', 'Site name')]),
            'brandUrl'   => ['/'],
            'options'    => [
                'class' => 'navbar-inverse',
                'role'  => 'banner',
            ],
        ]);

        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ],
            'items'   => $menuItems,
        ]);

        NavBar::end();

        break;

    case NavBarWidget::LINEAR_MENU:
        echo Menu::widget([
            'items'   => $menuItems,
            'options' => $options,
        ]);

        break;
}