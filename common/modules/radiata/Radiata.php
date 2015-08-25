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
use \common\modules\radiata\components\Migrator;

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
     * @var string App default language
     */
    protected $defaultLanguage;

    /**
     * @var string App active language
     */
    protected $activeLanguage;

    /**
     * @var string App backend default language
     */
    protected $defaultBackendLanguage;

    /**
     * @var string App backend default layout
     */
    public $backendLayout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        // more
    }

    /**
     *
     */
    public function getLanguages()
    {
        $languages = Yii::$app->cache->get('languages');
        if (!$languages) {


        }
        $this->availableLanguages = $languages;
    }

    /**
     * Get default language from available languages
     *
     * @return string Language code
     */
    public function getDefaultLanguage()
    {
        return reset(array_keys($this->availableLanguages));
    }

    /**
     * Get default language from available languages. Can be overwritten manually
     *
     * @return string Language code
     */
    public function getDefaultBackendLanguage()
    {
        return $this->defaultBackendLanguage ? $this->defaultBackendLanguage : reset(array_keys($this->availableLanguages));
    }

    /**
     * Get active language from URL
     *
     * @return void
     */
    public function getActiveLanguage()
    {
        $url = Yii::$app->request->pathInfo;

        $possibleLang = substr($url, 1, 2);

        $this->activeLanguage = isset($this->availableLanguages[$possibleLang]) ? $this->availableLanguages[$possibleLang] : $this->defaultLanguage;
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
