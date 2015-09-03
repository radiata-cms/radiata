<?php
namespace backend\modules\radiata\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use backend\modules\radiata\events\ClearCacheEvent;

class ClearCacheBehavior extends Behavior
{
    public function attach($owner)
    {
        parent::attach($owner);

        $owner->on(BaseActiveRecord::EVENT_BEFORE_INSERT, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_DELETE, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
    }
}