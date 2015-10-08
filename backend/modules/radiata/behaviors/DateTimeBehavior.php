<?php
namespace backend\modules\radiata\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class DateTimeBehavior extends AttributeBehavior
{
    public $attributes;

    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => 'date',
                BaseActiveRecord::EVENT_BEFORE_UPDATE => 'date',
                BaseActiveRecord::EVENT_AFTER_FIND    => 'date',
            ];
        }
    }

    public function evaluateAttributes($event)
    {
        if(!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                $event->data = $attribute;
                $value = $this->getValue($event);
                $this->owner->$attribute = $value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if($event->name == BaseActiveRecord::EVENT_AFTER_FIND) {
            return $this->owner->{$event->data} > 0 ? date(Yii::t('b/radiata/settings', 'dateTimePHPFormat'), $this->owner->{$event->data}) : '';
        } else {
            return (strtotime($this->owner->{$event->data}) > 0 ? strtotime($this->owner->{$event->data}) : '');
        }
    }
}