<?php
namespace backend\modules\radiata\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use backend\modules\radiata\events\AdminLogEvent;

class AdminLogBehavior extends Behavior
{
    public $titleAttribute = 'title';

    public function attach($owner)
    {
        parent::attach($owner);

        $owner->on(BaseActiveRecord::EVENT_BEFORE_INSERT, [AdminLogEvent::className(), AdminLogEvent::EVENT_CREATE_ITEM], $this->titleAttribute);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [AdminLogEvent::className(), AdminLogEvent::EVENT_UPDATE_ITEM], $this->titleAttribute);
        $owner->on(BaseActiveRecord::EVENT_BEFORE_DELETE, [AdminLogEvent::className(), AdminLogEvent::EVENT_DELETE_ITEM], $this->titleAttribute);
    }
}