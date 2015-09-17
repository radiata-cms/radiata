<?php
namespace backend\modules\radiata\widgets;

use backend\modules\radiata\components\BackendAccessControl;
use Yii;
use yii\base\Widget;

class ModulesBar extends Widget
{
    public $currentModule;

    /**
     * Renders the bar
     */
    public function run()
    {
        $lines = [];
        $modules = Yii::$app->getModules();

        foreach ($modules as $module) {
            if (!isset($module->id)) {
                $exploded = explode('\\', $module['class']);
                $moduleId = $exploded[count($exploded) - 2];
                $module = Yii::$app->getModule($moduleId);
            }
            if (method_exists($module, 'getPublic') && $module->public) {
                $lines = array_merge($lines, $this->subNavigation($module->id, $module->getBackendNavigation(), true));
            }
        }

        return implode("\n", $lines);
    }

    public function subNavigation($moduleId, $children, $isRoot = false)
    {
        $lines = [];
        if (count($children) > 0) {
            if (!$isRoot) $lines[] = '<ul class="treeview-menu">';
            foreach ($children as $child) {
                if ($this->canAccess($child, $moduleId)) {
                    $class = '';
                    if (count($child['children']) > 0) {
                        $class .= ' treeview';
                    }
                    if (
                        isset($child['isModule'])
                        &&
                        $this->currentModule->id == $moduleId
                        ||
                        isset($child['isActiveUrlPart'])
                        &&
                        (
                            substr(Yii::$app->request->url, 0, strlen($child['isActiveUrlPart'])) == $child['isActiveUrlPart']
                            ||
                            substr(Yii::$app->request->url, 3, strlen($child['isActiveUrlPart'])) == $child['isActiveUrlPart']
                        )
                    ) {
                        $class .= ' active';
                    }

                    $lines[] = '<li ' . ($class ? ' class="' . $class . '"' : '') . '>';
                    $lines[] = '<a href="' . $child['link'] . '">';
                    $lines[] = '<i class="' . $child['icon'] . '"></i><span>' . $child['title'] . '</span>';
                    if (count($child['children']) > 0) {
                        $lines[] = '<i class="fa fa-angle-left pull-right"></i>';
                    }
                    $lines[] = '</a>';

                    if (count($child['children']) > 0) {
                        $lines = array_merge($lines, $this->subNavigation($moduleId, $child['children']));
                    }

                    $lines[] = '</li>';
                }
            }
            if (!$isRoot) $lines[] = '</ul>';
        }

        return $lines;
    }

    //

    public function canAccess($child, $moduleId)
    {
        if (BackendAccessControl::checkFullAccess()) {

            return true;

        } elseif ($child['isModule']
            &&
            defined(get_class(Yii::$app->getModule($moduleId)) . '::BACKEND_PERMISSION')
            &&
            !Yii::$app->user->can(constant(get_class(Yii::$app->getModule($moduleId)) . '::BACKEND_PERMISSION'))
        ) {

            return true;

        } elseif ($child['permission'] && Yii::$app->user->can($child['permission'])) {

            return true;

        } elseif (isset($child['children'])) {
            foreach ($child['children'] as $subChild) {
                if ($this->canAccess($subChild, $moduleId)) {
                    return true;
                }
            }
        }

        return false;
    }
}