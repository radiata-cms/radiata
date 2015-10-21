<?php
/**
 * Configurator файл класса.
 * Component Configurator - custom configurator for modules
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata\helpers;

use Yii;

class PathHelper
{
    /**
     * Find all target paths
     *
     * @param array $configPaths
     * @param string $module
     * @param string $modulesDirName
     * @param string $targetDirName
     * @param bool $addRootLevel
     * @return array
     */
    static function getTargetPaths($configPaths, $module, $modulesDirName, $targetDirName, $addRootLevel = true)
    {
        $foundPaths = [];

        foreach ($configPaths as $migrationPathAlias) {
            $fullAlias = $migrationPathAlias;
            if($module != '') {
                $modulesParts = explode('/', $module);
                foreach ($modulesParts as $modulesPart) {
                    if(trim($modulesPart) != '') {
                        $fullAlias .= '/' . $modulesDirName . '/' . $modulesPart;
                    }
                }
                if($addRootLevel) {
                    $fullAlias .= '/' . $targetDirName;
                    $foundPaths[] = $fullAlias;
                }
            } else {
                if($addRootLevel) {
                    $fullAlias .= '/' . $targetDirName;
                    $foundPaths[] = $fullAlias;
                }
                $foundPaths = array_merge($foundPaths, self::getTargetPathsModules($migrationPathAlias . '/' . $modulesDirName, $modulesDirName, $targetDirName));
            }
        }

        return $foundPaths;
    }

    /**
     * Finds all modules paths with $targetDirName subdirectory. Uses recursion for submodules
     *
     * @param string $modulesPath
     * @param string $modulesDirName
     * @param string $targetDirName
     * @return array
     */
    static function getTargetPathsModules($modulesPath, $modulesDirName, $targetDirName)
    {
        $configPaths = [];

        $modulesRealPath = Yii::getAlias($modulesPath);
        if(is_dir($modulesRealPath)) {
            $handle = opendir($modulesRealPath);
            while (($file = readdir($handle)) !== false) {
                if($file === '.' || $file === '..') {
                    continue;
                }
                if(is_dir($modulesRealPath . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . $targetDirName)) {
                    $configPaths[] = $modulesPath . '/' . $file . '/' . $targetDirName;
                }
                if(is_dir($modulesRealPath . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . $modulesDirName)) {
                    $configPaths = array_merge($configPaths, self::getTargetPathsModules($modulesPath . '/' . $file . '/' . $modulesDirName, $modulesDirName, $targetDirName));
                }
            }
            closedir($handle);
        }

        return $configPaths;
    }

    /**
     * Get module alias by full directory path
     *
     * @param string $path
     * @param string $breakDirName
     * @param string $modulesDirName
     * @return string
     */
    static function getModuleAlias($path, $breakDirName, $modulesDirName)
    {
        $moduleAlias = '';

        $exploded = preg_split('/(\/|\\\)/', $path);
        if(count($exploded) > 0) {
            foreach ($exploded as $explodedPart) {
                if($explodedPart == $breakDirName) {
                    break;
                }
                if(empty($moduleAlias) && $explodedPart == $modulesDirName || !empty($moduleAlias)) {
                    if(empty($moduleAlias)) {
                        $moduleAlias = $explodedPart;
                    } else {
                        $moduleAlias .= '/' . $explodedPart;
                    }
                }
            }
            $moduleAlias = str_replace($modulesDirName . '/', '', $moduleAlias);
        }

        return $moduleAlias;
    }

}