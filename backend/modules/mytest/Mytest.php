<?php
namespace backend\modules\mytest;

use common\modules\radiata\interfaces\RadiataModuleInterface;

class Mytest extends \yii\base\Module implements RadiataModuleInterface
{
    public function getModuleIcon()
    {
        return 'fa fa-facebook';
    }

    public function getModuleMessages()
    {
        return 'b/mytest';
    }

    public function getPublic()
    {
        return true;
    }

    public function getBackendNavigation()
    {
        return [];
    }
}