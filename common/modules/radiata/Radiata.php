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
use yii\helpers\Url;
use common\modules\radiata\interfaces\RadiataModuleInterface;

/**
 * Class Radiata
 */
class Radiata extends \yii\base\Module implements RadiataModuleInterface
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

    public function getModuleIcon()
    {
        return 'fa fa-tree';
    }

    public function getModuleMessages()
    {
        return 'c/radiata';
    }

    public function getPublic()
    {
        return true;
    }

    /**
     * Backend navigation menu for module
     *
     * @return array
     */
    public function getBackendNavigation()
    {
        return [
            [
                'title' => Yii::t('c/radiata', 'Dashboard'),
                'icon' => 'fa fa-dashboard',
                'link' => Url::to(['/radiata/radiata/index']),
            ],
            [
                'title' => Yii::t('b/radiata/admin-log', 'Nav title'),
                'icon' => 'fa fa-history',
                'link' => Url::to(['/radiata/admin-log/index']),
            ],
            [
                'title' => Yii::t('c/radiata/lang', 'Nav title'),
                'icon' => 'fa fa-language',
                'link' => Url::to(['/radiata/langs/index']),
            ],
            [
                'title' => Yii::t('b/radiata/users', 'Nav title'),
                'icon' => 'fa fa-user',
                'link' => Url::to(['/radiata/users/index']),
                'children' => [
                    [
                        'title' => Yii::t('b/radiata/users', 'Nav list'),
                        'icon' => 'fa fa-users',
                        'link' => Url::to(['/radiata/users/index']),
                    ],
                    [
                        'title' => Yii::t('b/radiata/users', 'Nav create'),
                        'icon' => 'fa fa-user-plus',
                        'link' => Url::to(['/radiata/users/create']),
                    ],
                ],
            ],
        ];
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
