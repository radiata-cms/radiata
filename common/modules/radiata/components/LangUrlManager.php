<?php
namespace common\modules\radiata\components;

use Yii;
use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        $langPrefix = '';
        if(Yii::$app->getModule('radiata')->activeLanguage->code != Yii::$app->getModule('radiata')->defaultLanguage->code) {
            $langPrefix = '/' . Yii::$app->getModule('radiata')->activeLanguage->code;
        }
        $url = parent::createUrl($params);

        $parsedUrl = parse_url($url);

        if(isset($parsedUrl['scheme']) && $parsedUrl['scheme'] != '') {
            return str_replace($parsedUrl['path'], $langPrefix . $parsedUrl['path'], $url);
        } else {
            return $langPrefix . $url;
        }
    }
}