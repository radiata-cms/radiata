<?php
/**
 * Radiata файл класса.
 * Модуль radiata - основной модуль Radiata!
 *
 * Модуль Radiata содержит в себе все основные компоненты, которые используются другими модулями
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata;

use Yii;
use common\modules\radiata\components\Migrator;
use common\modules\radiata\models\Lang;

/**
 * Class Radiata
 */
class Radiata extends \yii\base\Module
{
    /**
     * @var string Version
     */
    const VERSION = '0.1.0';

    /**
     * @var array App languages
     */
    public $availableLanguages = [];

    /**
     * @var Lang App default language
     */
    public $defaultLanguage;

    /**
     * @var Lang App active language
     */
    public $activeLanguage;

    /**
     * @var string App backend default layout
     */
    public $backendLayout = 'main';

    /**
     * Init method
     */
    public function init()
    {
        parent::init();

        /*
        $migrator = new Migrator();
        //$migrator->direction = 'down';
        $migrator->migrate();
        echo '<pre>',print_r($migrator->error);
        exit();
        */

        $this->initLanguages();
    }

    /**
     * Get default language from available languages
     *
     * @return void
     */
    public function getDefaultLanguage()
    {
        foreach ($this->availableLanguages as $availableLanguage) {
            if ($availableLanguage->default == 1) {
                $this->defaultLanguage = $availableLanguage;
            }
        }
    }

    /**
     * Get active language from URL
     *
     * @param string $url
     *
     * return void
     */
    public function getActiveLanguageByUrl($url)
    {
        $possibleLang = substr($url, 1, 2);

        $this->activeLanguage = $this->getLanguageByCode($possibleLang);

        if (!$this->activeLanguage) $this->activeLanguage = $this->defaultLanguage;
    }

    /**
     * Get language by code
     *
     * @param $code
     *
     * @return Lang|null
     */
    public function getLanguageByCode($code)
    {
        foreach ($this->availableLanguages as $availableLanguage) {
            if ($code == $availableLanguage->code) {
                return $availableLanguage;
            }
        }

        return null;
    }

    /**
     * Init all languages data
     *
     * return void
     */
    public function initLanguages()
    {
        $this->availableLanguages = Lang::getLanguages();

        $this->getDefaultLanguage();
    }

    /**
     * Check for new migrations
     *
     * @param array $config
     * @return int
     */
    public function checkNewMigrations($config = [])
    {
        $migrator = new Migrator($config);
        $newMigrations = $migrator->findNewMigrations();
        return count($newMigrations);
    }

    /**
     * Migrations perform
     *
     * @param array $config
     * @return array
     */
    public function migrate($config = [])
    {
        $migrator = new Migrator($config);
        $migrations = $migrator->migrate();

        if (is_object($migrator->error)) {
            return [
                'error' => $migrator->error,
            ];
        } else {
            return [
                'migrations' => $migrations
            ];
        }
    }

}
