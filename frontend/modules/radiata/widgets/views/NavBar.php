<?
/* @var $this \yii\web\View */
/* @var string[] $menuItems */
/* @var array $options */
/* @var integer $type */

use frontend\modules\radiata\widgets\NavBarWidget;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

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
        echo '<ul' . (isset($options['class']) ? ' class="' . $options['class'] . '"' : '') . '>';
        foreach ($menuItems as $menuItem) {
            echo '<li>' . Html::a($menuItem['label'], $menuItem['url']) . '</li>';
        }
        echo '</ul>';

        break;
}