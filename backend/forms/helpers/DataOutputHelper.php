<?php
namespace backend\forms\helpers;

use Yii;

class DataOutputHelper
{

    /**
     * Renders a user roles view.
     *
     * @return string
     */
    public static function userRolesOutput($model, $attribute)
    {
        $html = '';
        $html .= '<div class="html-tree">';
        $html .= AuthHelper::buildHtmlTree($model, $attribute, AuthHelper::getRoles());
        $html .= '</div>';

        return $html;
    }

    /**
     * Renders a user permissions view.
     *
     * @return string
     */
    public static function userPermissionsOutput($model, $attribute)
    {
        $html = '';
        $html .= '<div class="html-tree">';
        $html .= AuthHelper::buildHtmlTree($model, $attribute, AuthHelper::getPermissions());
        $html .= '</div>';

        return $html;
    }
}