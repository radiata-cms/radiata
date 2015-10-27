<?php
namespace frontend\modules\news\widgets;

use common\modules\news\models\NewsTag;
use Yii;

class NewsTagsWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $tags = NewsTag::find()->language()->orderBy(['frequency' => SORT_DESC])->limit(10)->all();

        if(!empty($tags)) {
            return $this->render('NewsTags', [
                'tags' => $tags
            ]);
        } else {
            return '';
        }
    }
}

