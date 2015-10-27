<?php

namespace backend\modules\news\controllers;

use backend\modules\radiata\actions\tree\actionGetLevelData;
use backend\modules\radiata\actions\tree\actionMoveItem;
use backend\modules\radiata\components\BackendController;
use common\modules\news\models\NewsCategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class CategoryController extends BackendController
{
    const BACKEND_PERMISSION = 'News Module. Categories';

    public function actions()
    {
        return [
            'get-level-data' => [
                'class'      => actionGetLevelData::className(),
                'modelClass' => NewsCategory::className(),
            ],
            'move-item'      => [
                'class'      => actionMoveItem::className(),
                'modelClass' => NewsCategory::className(),
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
     * Lists all NewsCategory models.
     * @return mixed
     */
    public function actionIndex($parent_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NewsCategory::find()->where([NewsCategory::tableName() . '.parent_id' => $parent_id])->language()->orderBy(['position' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'parent_id'    => $parent_id,
        ]);
    }

    /**
     * Displays a single NewsCategory model.
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
     * Finds the NewsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = NewsCategory::find()->where(['id' => $id])->with('translations')->one();

        if($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new NewsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id = null)
    {
        $model = new NewsCategory();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsCategoryTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->status = NewsCategory::STATUS_ACTIVE;
            if($parent_id) {
                $model->parent_id = $parent_id;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NewsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsCategoryTranslation', []) as $language => $data) {
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
     * Deletes an existing NewsCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if(!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }


}
