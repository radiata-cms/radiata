<?php

namespace backend\modules\vote\controllers;

use backend\modules\radiata\components\BackendController;
use backend\modules\vote\models\VoteSearch;
use common\modules\vote\models\Vote;
use common\modules\vote\models\VoteOption;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * VoteController implements the CRUD actions for Vote model.
 */
class VoteController extends BackendController
{
    const BACKEND_PERMISSION = 'Votes Module';

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
     * Lists all Vote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'showSearchForm' => Yii::$app->request->queryParams,
        ]);
    }

    /**
     * Displays a single Vote model.
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
     * Creates a new Vote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vote();
        $modelOption = new VoteOption();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('VoteTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        } else {
            $model->status = Vote::STATUS_ACTIVE;
            $model->type = Vote::TYPE_SINGLE;
        }

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            if($model->save() && $model->saveOptions()) {
                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model'       => $model,
            'modelOption' => $modelOption,
        ]);
    }

    /**
     * Updates an existing Vote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOption = new VoteOption();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            if($model->save() && $model->saveOptions()) {
                $transaction->commit();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('update', [
            'model'       => $model,
            'modelOption' => $modelOption,
        ]);
    }

    /**
     * Deletes an existing Vote model.
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
     * Finds the Vote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Vote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
