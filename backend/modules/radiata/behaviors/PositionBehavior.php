<?php
namespace backend\modules\radiata\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class PositionBehavior extends AttributeBehavior
{
    public $positionAttribute = 'position';

    public $parentIdAttribute = 'parent_id';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->attributes = [
            BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->positionAttribute],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        $max = $this->owner
            ->find()
            ->andWhere([$this->parentIdAttribute => $this->owner->{$this->parentIdAttribute} ? $this->owner->{$this->parentIdAttribute} : null])
            ->max($this->positionAttribute);

        return $max ? ($max + 1) : 1;
    }
}