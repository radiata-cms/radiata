<?php
/**
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace backend\modules\radiata\helpers;

use ResourceBundle;
use Yii;

class RadiataHelper
{
    static function getActionName($action)
    {
        if(Yii::t('b/radiata/admin-log', 'action_' . $action) != 'action_' . $action) {
            return Yii::t('b/radiata/admin-log', 'action_' . $action);
        } else {
            return $action;
        }
    }

    static function getActionAdditionalIconClass($action)
    {
        switch ($action) {
            case 'createItem':
                $additionalIcon = 'fa-plus-square text-green';
                break;
            case 'updateItem':
                $additionalIcon = 'fa-pencil-square text-yellow';
                break;
            case 'deleteItem':
                $additionalIcon = 'fa-trash text-red';
                break;
            case 'wrongAuth':
            case 'wrongAuthLockScreen':
                $additionalIcon = 'fa-exclamation-triangle text-red';
                break;
            default:
                $additionalIcon = 'fa-info-circle text-blue';
                break;
        }

        return $additionalIcon;
    }

    static function getLocalesList()
    {
        $locales = [];
        $availableLocales = ResourceBundle::getLocales('');

        foreach ($availableLocales as $availableLocale) {
            if(strpos($availableLocale, '_') !== false) {
                $availableLocaleParts = explode("_", $availableLocale);
                if(count($availableLocaleParts) == 2 && in_array(strlen($availableLocaleParts[0]), [2, 3]) && strlen($availableLocaleParts[1]) == 2) {
                    $availableLocale = $availableLocaleParts[0] . '-' . $availableLocaleParts[1];
                    $locales[$availableLocale] = $availableLocale;
                }
            }
        }

        return $locales;
    }
}