<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Breadcrumbs extends Widget
{
    public $breadcrumbs = [];

    /**
     * Renders the bar
     */
    public function run()
    {
        $lines = [];
        $lines[] = '<ol class="breadcrumb">';
        $lines[] = '<li><a href="' . Url::to(['/radiata/radiata/index']) . '"><i class="fa fa-dashboard"></i>' . Yii::t('c/radiata', 'Dashboard') . '</a></li>';

        $module = Yii::$app->controller->module;
        if($module->id != 'radiata') {
            if(count($this->breadcrumbs) > 0) {
                $lines[] = '<li>';
                $lines[] = '<a href="' . Url::to(['/' . $module->id . '/' . $module->defaultRoute . '/' . $module->module->controller->defaultAction]) . '">';
                $lines[] = '<i class="' . $module->moduleIcon . '"></i> ' . Yii::t($module->moduleMessages, 'Module name');
                $lines[] = '</a>';
            } else {
                $lines[] = '<li class="active">';
                $lines[] = '<i class="' . $module->moduleIcon . '"></i> ' . Yii::t($module->moduleMessages, 'Module name');
            }
            $lines[] = '</li>';
        }

        if(count($this->breadcrumbs) > 0) {
            foreach ($this->breadcrumbs as $i => $value) {
                if($i == count($this->breadcrumbs) - 1) {
                    // last
                    $lines[] = '<li class="active">';
                } else {
                    $lines[] = '<li>';
                }
                if(is_array($value)) {
                    $lines[] = Html::a($value['label'], $value['url']);
                } else {
                    $lines[] = $value;
                }
                $lines[] = '</li>';
            }
        }
        $lines[] = '</ol>';

        return implode("\n", $lines);
    }
}