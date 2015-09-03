<?php
namespace backend\modules\mytest;

use common\modules\radiata\components\BaseRadiataModule;

class Mytest extends \yii\base\Module implements BaseRadiataModule
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