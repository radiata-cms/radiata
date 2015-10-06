<?php
namespace backend\modules\news\widgets;

use common\modules\news\models\NewsCategory;
use Yii;
use yii\helpers\Html;

class CategoriesNavBarWidget extends \yii\bootstrap\Widget
{
    public $parent_id;

    public function run()
    {
        if($this->parent_id) {
            $lines = [];
            $lines[] = '<div class="content-header">';
            $lines[] = '<ol class="breadcrumb breadcrumb-parents">';

            $lines[] = '<li>';
            $lines[] = Html::a(Yii::t('b/radiata/common', 'ROOT'), ['index']);
            $lines[] = '</li>';

            $category = NewsCategory::findOne($this->parent_id);
            if($category) {
                $categoryParents = $category->getParents();
                if($categoryParents) {
                    foreach ($categoryParents as $id => $title) {
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