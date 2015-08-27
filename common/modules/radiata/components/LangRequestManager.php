<?php
namespace common\modules\radiata\components;

use Yii;
use yii\web\Request;

class LangRequestManager extends Request
{
    private $langUrl;

    private $originalUrl;

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    public function getUrl()
    {

        if ($this->langUrl === null) {

            $this->langUrl = parent::getUrl();

            $this->originalUrl = $this->langUrl = parent::getUrl();

            $scriptName = '';
            if (strpos($this->langUrl, $_SERVER['SCRIPT_NAME']) !== false) {
                $scriptName = $_SERVER['SCRIPT_NAME'];
                $this->langUrl = substr($this->langUrl, strlen($scriptName));
            }

            Yii::$app->getModule('radiata')->getActiveLanguageByUrl($this->langUrl);

            if (Yii::$app->getModule('radiata')->activeLanguage->code) {
                Yii::$app->language = Yii::$app->getModule('radiata')->activeLanguage->locale;

                if (Yii::$app->getModule('radiata')->activeLanguage->code != Yii::$app->getModule('radiata')->defaultLanguage->code) {
                    $this->langUrl = substr($this->langUrl, strlen(Yii::$app->getModule('radiata')->activeLanguage->code) + 1);
                }
            }

            if (!$this->langUrl) $this->langUrl = $scriptName . '/';
        } else {
            $this->langUrl = parent::getUrl();
        }
        return $this->langUrl;
    }
}
