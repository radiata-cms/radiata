<?php
namespace frontend\modules\radiata\widgets;

use common\modules\menu\models\Menu;
use Yii;

class NavBarWidget extends \yii\bootstrap\Widget
{
    const MAIN_MENU_ID = 1;

    const BOOTSTRAP_NAVBAR = 1;

    const LINEAR_MENU = 2;

    public $menuId = '';

    public $options = [];

    public $type = self::BOOTSTRAP_NAVBAR;

    public function run()
    {
        if(!$this->menuId) {
            $this->menuId = self::MAIN_MENU_ID;
        }

        $menuItems = Menu::getMenu($this->menuId);

        return $this->render('NavBar', [
            'menuItems' => $menuItems,
            'options'   => $this->options,
            'type'      => $this->type,
        ]);
    }
}

