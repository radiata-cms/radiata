<?php
namespace frontend\modules\radiata\widgets;

use common\modules\menu\models\Menu;
use Yii;

class NavBarWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $menuItems = Menu::getMenu();

        return $this->render('NavBar', [
            'menuItems' => $menuItems
        ]);
    }
}

