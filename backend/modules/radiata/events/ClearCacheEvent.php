<?php
namespace backend\modules\radiata\events;

use common\modules\radiata\helpers\CacheHelper;
use Yii;
use yii\base\Event;

class ClearCacheEvent extends Event
{
    const EVENT_CLEAR_CACHE = 'clearCache';

    public function clearCache($event)
    {
        if (method_exists($event->sender, 'tableName')) {
            $tagName = $event->sender->tableName();
        } else {
            $tagName = join('', array_slice(explode('\\', get_class($event->sender)), -1));
        }

        CacheHelper::delete($tagName);
    }
}