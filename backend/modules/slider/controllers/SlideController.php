<?php

namespace backend\modules\slider\controllers;

use backend\modules\radiata\components\BackendController;
use common\modules\slider\models\Slide;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SlideController implements the CRUD actions for Slide model.
 */
class SlideController extends BackendController
{
    const BACKEND_PERMISSION = 'Sliders Module';

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

    public function actions()
    {
        return [
            'sortByPosition' => [
                'class'     => SortableGridAction::className(),
                'modelName' => Slide::className(),
            ],
        ];
    }

    /**
     * Lists all Slide models.
     * @return mixed
     */
    public function actionIndex($slider_id)
    {
        $dataProvider = new ActiveDataProvider([
            'query'      => Slide::find()->where(['slider_id' => $slider_id])->orderBy(['position' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'slider_id'    => $slider_id,
        ]);
    }

    /**
     * Displays a single Slide model.
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
     * Finds the Slide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Slide::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Slide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($slider_id = '')
    {
        $model = new Slide();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('SlideTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if(!empty($slider_id)) {
                $model->slider_id = $slider_id;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Slide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('SlideTranslation', []) as $language => $data) {
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
     * Deletes an existing Slide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $slider_id = $model->slider_id;
        $model->delete();

        return $this->redirect(['index', 'slider_id' => $slider_id]);
    }
}
