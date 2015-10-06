<?php
namespace backend\forms\widgets;

use backend\modules\radiata\behaviors\TreeBehavior;
use yii\helpers\Url;


class JSTreeWidget extends \yii\base\Widget
{
    public $options = [];

    public function run()
    {
        $options = $this->options;

        $JSTreeDivId = $options['JSTreeDivId'] ? $options['JSTreeDivId'] : 'jstree_div';
        $dataUrl = Url::to([$options['dataUrl'] ? $options['dataUrl'] : 'get-level-data']);
        $moveUrl = Url::to([$options['moveUrl'] ? $options['moveUrl'] : 'move-item']);
        $createUrl = Url::to([$options['createUrl'] ? $options['createUrl'] : 'create']);
        $editUrl = Url::to([$options['editUrl'] ? $options['editUrl'] : 'update']);
        $deleteUrl = Url::to([$options['deleteUrl'] ? $options['deleteUrl'] : 'delete']);
        $parentIdField = $options['parentIdField'] ? $options['parentIdField'] : 'parent_id';
        $jstPrefix = TreeBehavior::JST_PREFIX;

        return $this->render('JSTree', compact('JSTreeDivId', 'dataUrl', 'moveUrl', 'createUrl', 'editUrl', 'deleteUrl', 'parentIdField', 'jstPrefix'));
    }
}