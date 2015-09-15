<?php
namespace backend\forms\helpers;

use Yii;
use yii\helpers\Html;

class AuthHelper
{

    public static function getRoles()
    {
        return self::getSrtruct('Roles');
    }

    public static function getPermissions()
    {
        return self::getSrtruct('Permissions');
    }

    /**
     * @param string $method
     * @return array
     */
    public static function getSrtruct($method)
    {
        $roles = [];
        $method = 'get' . $method;

        foreach (Yii::$app->authManager->$method() as $role) {
            /** var $role yii\rbac\Role */
            if (!isset($roles[$role->name])) $roles[$role->name] = '';

            $children = Yii::$app->authManager->getChildren($role->name);
            if (count($children) > 0) {
                foreach ($children as $child) {
                    /** var $child yii\rbac\Role */
                    $roles[$child->name] = $role->name;
                }
            }
        }

        $tree = self::convertToTree($roles);

        return $tree;
    }

    public static function convertToTree($data, $parent = '')
    {

        $tree = [];
        foreach ($data as $k => $v) {
            if ($v == $parent) {
                $tree[$k] = self::convertToTree($data, $k);
            }
        }
        return $tree;
    }

    public static function buildHtmlTree($model, $attribute, $data)
    {
        $value = $model->$attribute;
        $lines = [];
        if (is_array($data) && count($data) > 0) {
            $lines[] = '<ul>';
            foreach ($data as $k => $v) {
                $lines[] = '<li>';

                $lines[] = '<div class="checkbox icheck">';
                $lines[] = Html::checkbox(Html::getInputName($model, $attribute) . '[' . $k . ']', isset($value[$k]), [
                    'value' => $k,
                    'label' => '<span>' . (Yii::t('b/radiata/user', $attribute . '_' . $k) != $attribute . '_' . $k ? Yii::t('b/radiata/user', $attribute . '_' . $k) : $k) . '</span>',
                ]);
                $lines[] = '</div>';

                if (is_array($v)) $lines[] = self::buildHtmlTree($model, $attribute, $v);
                $lines[] = '</li>';
            }
            $lines[] = '</ul>';
        }

        return join("\n", $lines);
    }
}