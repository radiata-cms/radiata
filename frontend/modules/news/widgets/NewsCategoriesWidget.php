<?php
namespace frontend\modules\news\widgets;

use common\modules\news\models\NewsCategory;
use Yii;

class NewsCategoriesWidget extends \yii\bootstrap\Widget
{
    public $parent_id = '';

    public function run()
    {
        $categories = [];

        $categoryModel = new NewsCategory();
        $categoryModel->structure = $categoryModel->getStructure();
        $categoriesIds = $categoryModel->structure[$this->parent_id]['children'];

        if(!empty($categoriesIds)) {
            foreach ($categoriesIds as $categoriesId) {
                if($categoryModel->structure[$categoriesId]['data']->isActive()) {
                    $categories[] = $categoryModel->structure[$categoriesId]['data'];
                }
            }
        }

        if(!empty($categories)) {
            return $this->render('NewsCategories', [
                'categories' => $categories
            ]);
        } else {
            return '';
        }
    }
}

