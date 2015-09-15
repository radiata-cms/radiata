<?php
namespace backend\modules\radiata\widgets;

use Yii;

class I18nSettingsWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $locale = Yii::$app->getModule('radiata')->activeLanguage->locale;

        $i18n = require(Yii::getAlias('@backend/modules/radiata/messages/' . $locale . '/settings.php'));

        return 'var i18n = ' . json_encode($i18n);
    }
}