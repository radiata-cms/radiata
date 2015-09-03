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
            if (isset($module->public)) {
                $lines[] = '<li' . ($this->currentModule->id == $module->id ? ' class="active"' : '') . '>
                    <a href="' . Url::to($module->id . '/' . $module->defaultRoute . '/' . $module->module->controller->defaultAction) . '">
                        <i class="' . $module->moduleIcon . '"></i><span>' . Yii::t($module->moduleMessages, 'Module name') . '</span>
                    </a>
                </li>';
            }
        }

        return implode("\n", $lines);
    }
}