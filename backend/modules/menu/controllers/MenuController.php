<?php

namespace backend\modules\menu\controllers;

use backend\modules\menu\models\MenuSearch;
use backend\modules\radiata\actions\tree\actionGetLevelData;
use backend\modules\radiata\actions\tree\actionMoveItem;
use backend\modules\radiata\components\BackendController;
use common\modules\menu\models\Menu;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BackendController
{
    const BACKEND_PERMISSION = 'Menu Module';

    public function actions()
    {
        return [
            'get-level-data' => [
                'class'      => actionGetLevelData::className(),
                'modelClass' => Menu::className(),
            ],
            'move-item'      => [
                'class'      => actionMoveItem::className(),
                'modelClass' => Menu::className(),
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex($parent_id = null)
    {
        $searchModel = new MenuSearch();
        $searchModel->parent_id = $parent_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;
        $dataProvider->pagination = false;
        $modelMenu = new Menu();

        return $this->render('index', [
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'modelMenu'      => $modelMenu,
            'parent_id'      => $parent_id,
            'showSearchForm' => Yii::$app->request->queryParams,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id = null)
    {
        $model = new Menu();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('MenuTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->status = Menu::STATUS_ACTIVE;
            if($parent_id) {
                $model->parent_id = $parent_id;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('MenuTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Menu::find()->where(['id' => $id])->with('translations')->one();

        if($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
