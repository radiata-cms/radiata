<?php
namespace backend\forms\widgets;

use Yii;

class LangInputWidget extends \yii\widgets\InputWidget
{
    public $options = [];

    public function run()
    {
        $options = $this->options;
        $model = $this->model;
        $attribute = $this->attribute;
        $languages = Yii::$app->getModule('radiata')->availableLanguages;

        return $this->render('LangInput', compact('options', 'model', 'attribute', 'languages'));
    }
}