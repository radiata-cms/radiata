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

    const JST_PREFIX = 'jst';

    public function moveItem($parentId, $afterItemId = 0)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $this->changeItemParent($parentId);
        $this->changeItemPosition($afterItemId);
        $this->shiftItemsPositionAfter($this->owner);
        if($this->owner->save()) {
            $transaction->commit();
        } else {
            $transaction->rollBack();
        }
    }

    public function changeItemParent($parentId)
    {
        if($this->checkItemExists($parentId) && $this->owner->{$this->parentFieldName} != $parentId) {
            $this->owner->setAttribute($this->parentFieldName, $parentId);
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
                $this->positionItemAfter($afterItemId);
            } else {
                $this->positionItemToBeginning();
            }
        }
    }

    protected function shiftItemsPositionAfter($afterItem)
    {
        $position = $afterItem->{$this->positionFieldName};
        $shiftedItems = $this->getShiftItems($afterItem);
        if($shiftedItems) {
            foreach ($shiftedItems as $shiftedItem) {
                $shiftedItem->setAttribute($this->positionFieldName, ++$position);
                $shiftedItem->save();
            }
        }
    }

    protected function getShiftItems($afterItem)
    {
        return $this->owner->find()
            ->andWhere(['>=', $this->positionFieldName, $afterItem->{$this->positionFieldName}])
            ->andWhere([$this->parentFieldName => $afterItem->{$this->parentFieldName}])
            ->andWhere(['<>', 'id', $this->owner->id])
            ->orderBy([$this->positionFieldName => SORT_ASC])->all();
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

    protected function positionItemToBeginning()
    {
        $this->owner->{$this->positionFieldName} = 1;
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

        $result = ['' => $this->structure['']['title']] + $this->getItemsTreeLevelRecursive($this->structure['']['children']);

        return $result;
    }

    public function getItemsForLinkedField()
    {
        $this->structure = $this->getStructure();

        $result = ['' => Yii::t('b/radiata/common', 'Please choose')] + $this->getItemsTreeLevelRecursive($this->structure['']['children']);

        return $result;
    }

    public function getItemsTreeLevelRecursive($children = [], $level = 0)
    {
        $items = [];
        foreach ($children as $child) {
            if(!$this->owner->hasAttribute('id') || $this->owner->id != $child) {
                $items[$child] = str_repeat(' ', ($level + 1) * 6) . $this->structure[$child]['title'];
                if(count($this->structure[$child]['children']) > 0) {
                    $items += $this->getItemsTreeLevelRecursive($this->structure[$child]['children'], $level + 1);
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
                'id'     => self::JST_PREFIX,
                'title'    => Yii::t('b/radiata/common', 'ROOT'),
                'parent' => '',
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
                    'id'     => self::JST_PREFIX . $item->id,
                    'title'    => $item->{$this->titleFieldName},
                    'parent' => $item->{$this->parentFieldName},
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

    public function getTreeData($nodeId)
    {
        $this->structure = $this->getStructure();

        return $this->buildTreeDataLevel($this->structure[$nodeId]);
    }

    public function buildTreeDataLevel($structure)
    {
        $data = [
            'id'   => $structure['id'],
            'text' => $structure['title'],
        ];

        if(!empty($structure['children'])) {
            foreach ($structure['children'] as $child) {
                $data['children'][] = $this->buildTreeDataLevel($this->structure[$child]);
            }
        }

        return $data;
    }

    public function getParents()
    {
        $this->structure = $this->getStructure();

        $parents = [];
        $parent = $this->structure[$this->owner->id]['parent'];
        while ($parent != '') {
            $parents[$parent] = $this->structure[$parent]['title'];
            $parent = $this->structure[$parent]['parent'];
        }

        return array_reverse($parents, true);
    }
}