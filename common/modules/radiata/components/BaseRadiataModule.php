<?php
namespace common\modules\radiata\components;

interface BaseRadiataModule
{
    function getModuleIcon();

    function getModuleMessages();

    function getPublic();

    function getBackendNavigation();
}