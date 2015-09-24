<?php
namespace backend\modules\radiata\behaviors;

use common\modules\radiata\helpers\CacheHelper;
use Yii;
use yii\base\Behavior;
use yii\web\BadRequestHttpException;

class TreeBehavior extends Behavior
{
    public $parentFieldName = 'parent_id';
    
    public $positionFieldName = 'position';

    public $titleFieldName = 'title';

    public $translationRelation = 'translations';

    public $structure = [];

    public function moveItem($parentId, $afterItemId = 0)
    {
        $this->changeItemParent($parentId);
        $this->changeItemPosition($afterItemId);
    }

    public function changeItemParent($parentId)
    {
        if($this->checkItemExists($parentId) && $this->owner->{$this->parentFieldName} != $parentId) {
            $this->owner->setAttribute($this->parentFieldName, $parentId)->save();
        }
    }

    public function checkItemExists($itemId)
    {
        if($itemId == 0 || $this->owner->findOne($itemId)) {
            return true;
        } else {
            throw new BadRequestHttpException();
        }
    }

    public function changeItemPosition($afterItemId = 0)
    {
        if($this->checkItemExists($afterItemId)) {
            if($afterItemId > 0) {
                Yii::$app->db->transaction(function () use ($afterItemId) {
                    $this->shiftItemsPositionAfter($afterItemId);
                    $this->positionItemAfter($afterItemId);
                });
            } else {
                $this->positionItemToEnd();
            }
        }
    }

    protected function shiftItemsPositionAfter($afterItemId)
    {
        $afterItem = $this->owner->findOne($afterItemId);
        $shiftedItems = $this->getShiftItems($afterItem);
        if($shiftedItems) {
            foreach ($shiftedItems as $shiftedItem) {
                $this->owner->setAttribute($shiftedItem->positionFieldName, $shiftedItem->positionFieldName + 1)->save();
            }
        }
    }

    protected function getShiftItems($afterItem)
    {
        return $this->owner->find()
            ->where([$this->positionFieldName > $afterItem->{$this->positionFieldName}])
            ->orderBy([$this->positionFieldName => SORT_ASC]);
    }

    protected function positionItemAfter($afterItemId)
    {
        $afterItem = $this->owner->findOne($afterItemId);
        if($afterItem) {
            $this->owner->{$this->positionFieldName} = $afterItem->{$this->positionFieldName} + 1;
        } else {
            throw new BadRequestHttpException();
        }
    }

    protected function positionItemToEnd()
    {
        $lastItem = $this->owner->find()->orderBy([$this->positionFieldName => SORT_ASC])->limit(1);
        if($lastItem) {
            $this->owner->{$this->positionFieldName} = $lastItem->{$this->positionFieldName} + 1;
        } else {
            $this->owner->{$this->positionFieldName} = 1;
        }
        $this->owner->save();
    }

    public function getChildren()
    {
        $this->structure = $this->getStructure();

        return $this->structure[$this->owner->id]['children'];
    }

    public function getChildrenCount()
    {
        return count($this->getChildren());
    }

    public function getItemsForMultipleChoice()
    {
        $this->structure = $this->getStructure();

        return $this->getItemsTreeLevelRecursive($this->structure['']['children']);
    }

    public function getItemsForDropDownList()
    {
        $this->structure = $this->getStructure();

        $result = array_merge(['' => $this->structure['']['title']], $this->getItemsTreeLevelRecursive($this->structure['']['children']));

        return $result;
    }

    public function getItemsTreeLevelRecursive($children = [], $level = 0)
    {
        $items = [];
        foreach ($children as $child) {
            if(!$this->owner->hasAttribute('id') || $this->owner->id != $child) {
                $items[$child] = str_repeat(' ', ($level + 1) * 6) . $this->structure[$child]['title'];
                if(count($child['children']) > 0) {
                    $items = array_merge($items, $this->getItemsTreeLevelRecursive($child['children'], $level + 1));
                }
            }
        }

        return $items;
    }

    public function getStructure()
    {
        $owner = $this->owner;
        $cacheKey = $owner::className() . '_items_tree' . rand(0, 10000);
        $structure = CacheHelper::get($cacheKey);
        if(!$structure) {
            $structure = $this->makeStructure();
            CacheHelper::set($cacheKey, $structure, CacheHelper::getTag($owner::className()));
        }

        return $structure;
    }

    public function makeStructure()
    {
        $itemsStructure = [
            // top level
            '' => [
                'title'    => Yii::t('b/radiata/common', 'ROOT'),
                'children' => [],
            ]
        ];

        if($this->translationRelation) {
            $allItems = $this->owner->find()
                ->language()
                ->joinWith($this->translationRelation)
                ->orderBy([$this->positionFieldName => SORT_ASC])
                ->all();
        } else {
            $allItems = $this->owner->find()
                ->language()
                ->orderBy([$this->positionFieldName => SORT_ASC])
                ->all();
        }

        if($allItems) {
            foreach ($allItems as $item) {
                $itemsStructure[$item->id] = [
                    'title'    => $item->{$this->titleFieldName},
                    'children' => [],
                ];
            }

            foreach ($allItems as $item) {
                if(isset($itemsStructure[$item->{$this->parentFieldName}])) {
                    $itemsStructure[$item->{$this->parentFieldName}]['children'][] = $item->id;
                }
            }
        }

        return $itemsStructure;
    }
}