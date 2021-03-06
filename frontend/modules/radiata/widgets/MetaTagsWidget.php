<?php
namespace frontend\modules\radiata\widgets;

use Yii;

class MetaTagsWidget extends \yii\bootstrap\Widget
{
    public $type = '';

    public $item = '';

    public function run()
    {
        $metaTags = [];

        switch ($this->type) {
            case 'tag':
                $metaTags[] = [
                    'name'    => 'meta_title',
                    'content' => $this->item->name,
                ];
                $metaTags[] = [
                    'name'    => 'meta_keywords',
                    'content' => $this->item->name,
                ];
                break;
            default:
                $metaTags[] = [
                    'name'    => 'meta_title',
                    'content' => !empty($this->item->meta_title) ? $this->item->meta_title : $this->item->title,
                ];
                $metaTags[] = [
                    'name' => 'keywords',
                    'content' => $this->item->meta_keywords,
                ];
                $metaTags[] = [
                    'name' => 'description',
                    'content' => $this->item->meta_description,
                ];
                break;
        }

        return $this->render('MetaTags', [
            'metaTags' => $metaTags
        ]);
    }
}

