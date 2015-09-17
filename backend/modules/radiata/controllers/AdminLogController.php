<?php

namespace backend\modules\radiata\controllers;

use Yii;
use backend\modules\radiata\models\AdminLogSearch;
use backend\modules\radiata\components\BackendController;

/**
 * AdminLogController implements the CRUD actions for AdminLog model.
 */
class AdminLogController extends BackendController
{
    const BACKEND_PERMISSION = 'Radiata Module. Admin log';

    /**
     * Lists all AdminLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
