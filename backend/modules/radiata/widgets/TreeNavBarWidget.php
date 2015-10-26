<?php
namespace backend\modules\radiata\widgets;

use Yii;
use yii\helpers\Html;

class TreeNavBarWidget extends \yii\bootstrap\Widget
{
    public $parent_id;
    
    public $className;

    public function run()
    {
        if($this->parent_id) {
            $lines = [];
            $lines[] = '<div class="content-header">';
            $lines[] = '<ol class="breadcrumb breadcrumb-parents">';

            $lines[] = '<li>';
            $lines[] = Html::a(Yii::t('b/radiata/common', 'ROOT'), ['index']);
            $lines[] = '</li>';

            $class = $this->className;
            $item = $class::findOne($this->parent_id);
            if($item) {
                $itemParents = $item->getParents();
                if($itemParents) {
                    foreach ($itemParents as $id => $title) {
                        $lines[] = '<li>';
                        $lines[] = Html::a($title, ['index', 'parent_id' => $id]);
                        $lines[] = '</li>';
                    }
                }
            }
            $lines[] = '</ol>';
            $lines[] = '</div>';

            return implode("\n", $lines);
        }
    }
}