<?php
namespace backend\modules\radiata\behaviors;

use backend\modules\radiata\events\ClearCacheEvent;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class CacheBehavior extends Behavior
{
    public function attach($owner)
    {
        parent::attach($owner);

        $owner->on(BaseActiveRecord::EVENT_BEFORE_INSERT, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_DELETE, [ClearCacheEvent::className(), ClearCacheEvent::EVENT_CLEAR_CACHE]);
    }
}