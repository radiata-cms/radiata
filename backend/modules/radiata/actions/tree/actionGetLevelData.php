<?php
namespace backend\modules\radiata\actions\tree;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class actionGetLevelData extends Action
{
    public $modelClass;

    public function run($nodeId = '')
    {
        $model = new $this->modelClass;
        if($nodeId == 0 || $model->findOne($nodeId)) {
            $data = $model->getTreeData($nodeId);
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $data;
        } else {
            throw new BadRequestHttpException();
        }
    }
}