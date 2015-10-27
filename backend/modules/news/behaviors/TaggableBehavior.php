<?php
namespace backend\modules\news\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * TaggableBehavior
 *
 * @property ActiveRecord $owner
 *
 */
class TaggableBehavior extends Behavior
{
    public $tagRelation = 'tags';
    /**
     * @var string the tags model id attribute
     */
    public $tagIdAttribute = 'id';
    /**
     * @var string the tags model name attribute
     */
    public $tagNameAttribute = 'name';
    /**
     * @var string|false the tags model frequency attribute name
     */
    public $tagFrequencyAttribute = 'frequency';
    /**
     * @var string[]
     */
    private $_tagIds;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Returns tags.
     * @return string|string[]
     */
    public function getTagIds($asArray = false)
    {
        if(!$this->owner->getIsNewRecord() && $this->_tagIds === null) {
            $this->_tagIds = [];

            /* @var ActiveRecord $tag */
            foreach ($this->owner->{$this->tagRelation} as $tag) {
                $this->_tagIds[] = $tag->getAttribute($this->tagIdAttribute);
            }
        }

        if($asArray) {
            return $this->_tagIds;
        } else {
            return $this->_tagIds === null ? '' : implode(', ', $this->_tagIds);
        }
    }

    /**
     * Set tags.
     * @param string|string[] $values
     * @return string|string[]
     */
    public function setTagIds($values)
    {
        $this->_tagIds = $this->filterTagValues($values);
    }

    /**
     * Filters tags.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterTagValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }

    /**
     * Returns tags for input.
     * @return string|string[]
     */
    public function getTagItems()
    {
        $items = [];

        if(!$this->owner->getIsNewRecord()) {
            foreach ($this->owner->{$this->tagRelation} as $tag) {
                $items[] = [
                    $this->tagIdAttribute   => $tag->{$this->tagIdAttribute},
                    $this->tagNameAttribute => $tag->{$this->tagNameAttribute},
                ];
            }
        }

        return \yii\helpers\Json::encode($items);
    }

    /**
     * @return void
     */
    public function afterSave()
    {
        if($this->_tagIds === null) {
            return;
        }

        if(!$this->owner->getIsNewRecord()) {
            $this->beforeDelete();
        }

        $tagRelation = $this->owner->getRelation($this->tagRelation);
        $pivot = $tagRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $tagRelation->modelClass;
        $rows = [];

        foreach ($this->_tagIds as $value) {
            /* @var ActiveRecord $tag */
            $tag = $class::findOne([$this->tagIdAttribute => $value]);

            if($tag === null) {
                $tag = new $class();
                $tag->setAttribute($this->tagIdAttribute, $value);
            }

            if($this->tagFrequencyAttribute !== false) {
                $frequency = $tag->getAttribute($this->tagFrequencyAttribute);
                $tag->setAttribute($this->tagFrequencyAttribute, ++$frequency);
            }

            if($tag->save()) {
                $rows[] = [$this->owner->getPrimaryKey(), $tag->getPrimaryKey()];
            }
        }

        if(!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($tagRelation->via->link), current($tagRelation->link)], $rows)
                ->execute();
        }
    }

    /**
     * @return void
     */
    public function beforeDelete()
    {
        $tagRelation = $this->owner->getRelation($this->tagRelation);
        $pivot = $tagRelation->via->from[0];

        if($this->tagFrequencyAttribute !== false) {
            /* @var ActiveRecord $class */
            $class = $tagRelation->modelClass;

            $pks = (new Query())
                ->select(current($tagRelation->link))
                ->from($pivot)
                ->where([key($tagRelation->via->link) => $this->owner->getPrimaryKey()])
                ->column($this->owner->getDb());

            if(!empty($pks)) {
                $class::updateAllCounters([$this->tagFrequencyAttribute => -1], ['in', $class::primaryKey(), $pks]);
            }
        }

        $this->owner->getDb()
            ->createCommand()
            ->delete($pivot, [key($tagRelation->via->link) => $this->owner->getPrimaryKey()])
            ->execute();
    }
}
