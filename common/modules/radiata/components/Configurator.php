<?php
/**
 * Configurator файл класса.
 * Component Configurator - custom configurator for modules
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata\components;

use Yii;
use common\modules\radiata\helpers\PathHelper;
use yii\helpers\ArrayHelper;

/**
 * Class Configurator
 */
class Configurator extends \yii\base\Object
{
    /**
     * @var array
     */
    public $configPaths = ['@frontend', '@common', '@backend'];

    /**
     * @var string
     */
    public $configDir = 'config';

    /**
     * @var string
     */
    public $i18nDir = 'messages';

    /**
     * @var string
     */
    public $i18nClass = 'yii\i18n\PhpMessageSource';

    /**
     * @var string
     */
    public $modulesDir = 'modules';

    /**
     * @var array
     */
    public $configFilesNames = [
        'bootstrap', 'main'
    ];

    /**
     * @var string
     */
    public $additionalSuffix = '-local';

    /**
     * @var string
     */
    public $module = '';

    /**
     * @var array
     */
    public $config = [];


    /**
     * Gather all modules configurations
     *
     * @return array
     */
    public function loadAll()
    {
        $configPaths = PathHelper::getTargetPaths($this->configPaths, $this->module, $this->modulesDir, $this->configDir, false);

        $finalConfig = [];
        foreach ($configPaths as $configPath) {
            $realPath = Yii::getAlias($configPath);
            foreach ($this->configFilesNames as $configFilesName) {
                if (file_exists($realPath . DIRECTORY_SEPARATOR . $configFilesName . '.php'))
                    $finalConfig = ArrayHelper::merge($finalConfig, require($realPath . DIRECTORY_SEPARATOR . $configFilesName . '.php'));
                if ($this->additionalSuffix && file_exists($realPath . DIRECTORY_SEPARATOR . $configFilesName . $this->additionalSuffix . '.php'))
                    $finalConfig = ArrayHelper::merge($finalConfig, require($realPath . DIRECTORY_SEPARATOR . $configFilesName . $this->additionalSuffix . '.php'));
            }

        }

        $this->config = $finalConfig;

        $this->loadI18n();

        return $finalConfig;
    }

    /**
     * Gather all i18n messages files
     *
     * @return array
     */
    public function loadI18n()
    {
        $i18nPaths = PathHelper::getTargetPaths($this->configPaths, $this->module, $this->modulesDir, $this->i18nDir, false);

        $i18nConfig = [
            'components' => [
                'i18n' => [
                    'translations' => []
                ]
            ]
        ];

        foreach ($i18nPaths as $i18nPath) {
            $realPath = Yii::getAlias($i18nPath);
            if (is_dir($realPath)) {
                $fileMap = [];
                $handle = opendir($realPath);
                $categoryPrefix = 'c';
                $categoryName = '';
                while (($dir = readdir($handle)) !== false) {
                    if ($dir === '.' || $dir === '..') {
                        continue;
                    }
                    if (is_dir($realPath . DIRECTORY_SEPARATOR . $dir)) {

                        if (!$categoryName) {
                            foreach ($this->configPaths as $configPath) {
                                if (strpos(substr($configPath, 1), $realPath) !== false) {
                                    $categoryPrefix = substr($configPath, 1, 1);
                                    break;
                                }
                            }
                            $categoryName = PathHelper::getModuleAlias($realPath . DIRECTORY_SEPARATOR . $dir, $this->i18nDir, $this->modulesDir);
                            $categoryName = $categoryPrefix . '/' . $categoryName;
                        }

                        $filesHandle = opendir($realPath . DIRECTORY_SEPARATOR . $dir);
                        while (($file = readdir($filesHandle)) !== false) {
                            if ($file === '.' || $file === '..') {
                                continue;
                            }
                            $categoryAlias = str_replace('.php', '', $file);
                            if ($categoryPrefix . '/' . $categoryAlias == $categoryName) {
                                $fileMap[$categoryName] = $file;
                            } else {
                                $fileMap[$categoryName . '/' . $categoryAlias] = $file;
                            }

                        }
                        closedir($filesHandle);
                    }
                }
                closedir($handle);

                $i18nConfig['components']['i18n']['translations'][$categoryName . '*'] = [
                    'class' => $this->i18nClass,
                    'basePath' => $i18nPath,
                    'forceTranslation' => true,
                    'fileMap' => $fileMap,
                ];
            }
        }

        $this->config = ArrayHelper::merge($this->config, $i18nConfig);
    }

    /**
     * Merge configurations
     *
     * @return array
     */
    public function mergeConfig($customConfig)
    {
        return ArrayHelper::merge($customConfig, $this->config);
    }
}