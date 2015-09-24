<?php
namespace backend\modules\radiata\components\jstree;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class JSTreeController extends Controller
{
    public $modelClass;

    public $model;

    public function init()
    {
        $this->model = new $this->modelClass;

        parent::init();
    }

    public function actionMoveItem($itemId, $parentId, $afterItemId)
    {
        $item = $this->model->findOne($itemId);
        if($item) {
            $item->moveItem($parentId, $afterItemId);
        } else {
            throw new BadRequestHttpException();
        }
    }
}