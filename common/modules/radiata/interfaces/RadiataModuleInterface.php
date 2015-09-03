<?php
namespace common\modules\radiata\interfaces;

interface RadiataModuleInterface
{
    function getModuleIcon();

    function getModuleMessages();

    function getPublic();

    function getBackendNavigation();
}