<?php
namespace frontend\modules\radiata\widgets;

use Yii;

class GalleryWidget extends \yii\bootstrap\Widget
{
    public $gallery = [];

    public function run()
    {
        if(!empty($this->gallery)) {
            return $this->render('Gallery', [
                'gallery' => $this->gallery
            ]);
        } else {
            return '';
        }
    }
}

