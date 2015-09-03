<?php
namespace common\modules\radiata\helpers;

use Yii;
use yii\caching\TagDependency;

class CacheHelper
{

    static function get($key)
    {
        return Yii::$app->cache->get($key);
    }

    static function set($key, $data, $tags = '', $time = 2592000)
    {
        Yii::$app->cache->set($key, $data, $time, new TagDependency(['tags' => $tags]));
    }

    static function delete($tags = '')
    {
        TagDependency::invalidate(Yii::$app->cache, $tags);
    }
}