<?php
namespace backend\modules\radiata\widgets;

use Yii;

class LangSwitcherWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        return $this->render('LangSwitcher', [
            'current' => Yii::$app->getModule('radiata')->activeLanguage,
            'languages' => Yii::$app->getModule('radiata')->availableLanguages,
        ]);
    }
}