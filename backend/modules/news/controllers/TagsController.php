<?php

namespace backend\modules\news\controllers;

use backend\forms\helpers\FieldHelper;
use backend\modules\news\models\NewsTagsSearch;
use backend\modules\radiata\components\BackendController;
use common\modules\news\models\NewsTags;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * NewsTagsController implements the CRUD actions for NewsTags model.
 */
class TagsController extends BackendController
{
    const BACKEND_PERMISSION = 'News Module. Tags';

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
     * Lists all NewsTags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsTagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel'    => $searchModel,
            'dataProvider'   => $dataProvider,
            'showSearchForm' => Yii::$app->request->queryParams,
        ]);
    }

    /**
     * Displays a single NewsTags model.
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
     * Creates a new NewsTags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NewsTags();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsTagsTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if(Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NewsTags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsTagsTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if(Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NewsTags model.
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
     * Finds the NewsTags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsTags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = NewsTags::find()->where(['id' => $id])->with('translations')->one();

        if($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Tags list
     * @return array
     */
    public function actionTagsList($query)
    {
        $items = [];

        if($query) {
            $models = NewsTags::find([
                ['like', 'name', $query],
            ])->with('translations')->all();


            foreach ($models as $model) {
                $items[] = [
                    'id'   => $model->id,
                    'name' => $model->name,
                ];
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return $items;
    }

    /**
     * Add tag modal window
     * @return array
     */
    public function actionAddNewTag()
    {
        if(Yii::$app->request->isAjax) {
            $model = new NewsTags();

            if(Yii::$app->request->isPost) {
                foreach (Yii::$app->request->post('NewsTagsTranslation', []) as $language => $data) {
                    foreach ($data as $attribute => $translation) {
                        $model->translate($language)->$attribute = $translation;
                    }
                }
            }

            if(Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($model->save()) {
                    return [
                        'newId'   => $model->id,
                        'newName' => $model->name,
                    ];
                } else {
                    return ['errors' => FieldHelper::showErrors($model)];
                }
            } else {
                return $this->renderAjax('newTagAjax', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new BadRequestHttpException();
        }
    }
}
