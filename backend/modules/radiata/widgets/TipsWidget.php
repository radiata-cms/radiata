<?php
namespace backend\modules\radiata\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class TipsWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $tips = [];

        $activeLocale = Yii::$app->getModule('radiata')->activeLanguage['locale'];

        $files = FileHelper::findFiles(Yii::getAlias('@backend/modules/radiata/tips' . DIRECTORY_SEPARATOR . $activeLocale));
        if($files) {
            foreach ($files as $file) {
                $tips = ArrayHelper::merge($tips, require($file));
            }
        }
        shuffle($tips);

        if(count($tips) > 0) {
            return $this->render('Tips', [
                'tips' => $tips
            ]);
        } else {
            return '';
        }
    }
}