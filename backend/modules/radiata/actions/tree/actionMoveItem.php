<?php
namespace backend\modules\radiata\actions\tree;

use backend\modules\radiata\helpers\RadiataHelper;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;

class actionMoveItem extends Action
{
    public $modelClass;

    public function run()
    {
        $itemId = RadiataHelper::getTreeNodeItemId(Yii::$app->request->post('nodeId'));
        $parentId = RadiataHelper::getTreeNodeItemId(Yii::$app->request->post('parentId'));
        $afterItemId = RadiataHelper::getTreeNodeItemId(Yii::$app->request->post('afterItemId'));

        $model = new $this->modelClass;

        $item = $model->findOne($itemId);
        if($item) {
            $item->moveItem($parentId, $afterItemId);
        } else {
            throw new BadRequestHttpException();
        }
    }
}