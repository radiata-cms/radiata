<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

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
                $lines[] = '<li' . ($this->currentModule->id == $module->id ? ' class="active"' : '') . '>';
                $lines[] = '<a href="' . Url::to(['/' . $module->id . '/' . $module->defaultRoute . '/' . $module->module->controller->defaultAction]) . '">';
                $lines[] = '<i class="' . $module->moduleIcon . '"></i><span>' . Yii::t($module->moduleMessages, 'Module name') . '</span>';
                $lines[] = '</a>';
                $lines = array_merge($lines, $this->subNavigation($module));
                $lines[] = '</li>';
            }
        }

        return implode("\n", $lines);
    }

    public function subNavigation($module, $children = [])
    {

        if (count($children) == 0) {
            $children = $module->getBackendNavigation();
            $class = 'treeview';
        } else {
            $class = '';
        }
        $lines = [];

        if (count($children) > 0) {
            $lines[] = '<ul class="treeview-menu">';
            foreach ($children as $child) {

                if (count($child['children']) > 0) {
                    $lines[] = '<li class="' . $class . '">';
                } else {
                    $lines[] = '<li>';
                }
                $lines[] = '<a href="' . $child['link'] . '">';
                $lines[] = '<i class="' . $child['icon'] . '"></i><span>' . $child['title'] . '</span>';
                if (count($child['children']) > 0) {
                    $lines[] = '<i class="fa fa-angle-left pull-right"></i>';
                }
                $lines[] = '</a>';

                if (count($child['children']) > 0) {
                    $lines = array_merge($lines, $this->subNavigation($module, $child['children']));
                }

                $lines[] = '</li>';
            }
            $lines[] = '</ul>';
        }

        return $lines;
    }
}