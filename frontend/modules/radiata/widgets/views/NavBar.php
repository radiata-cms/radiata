<?
/* @var $this \yii\web\View */
/* @var string[] $menuItems */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

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
