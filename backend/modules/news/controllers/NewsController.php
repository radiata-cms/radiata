<?php

namespace backend\modules\news\controllers;

use backend\modules\news\models\NewsSearch;
use backend\modules\radiata\components\BackendController;
use common\modules\news\models\News;
use common\modules\news\models\NewsCategory;
use vova07\imperavi\actions\GetAction;
use vova07\imperavi\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends BackendController
{
    const BACKEND_PERMISSION = 'News Module. News tape';

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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;
        $modelCategory = new NewsCategory();

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'modelCategory' => $modelCategory,
            'showSearchForm' => Yii::$app->request->queryParams,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $modelCategory = new NewsCategory();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save() && $model->saveGallery()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->status = News::STATUS_ACTIVE;

            return $this->render('create', [
                'model'         => $model,
                'modelCategory' => $modelCategory,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCategory = new NewsCategory();

        if(Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('NewsTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }
        }

        if($model->load(Yii::$app->request->post()) && $model->save() && $model->saveGallery()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model'         => $model,
                'modelCategory' => $modelCategory,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = News::find()->where(['id' => $id])->with('translations')->with('categories')->one();

        if($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Fake gallery item deletion. Required by plugin
     * @return string
     */
    public function actionGalleryDeleteFake()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return '{}';
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $baseUrl = '/uploads/redactor/news/' . Yii::$app->user->id . '/';

        return [
            'image-upload' => [
                'class' => UploadAction::className(),
                'url'   => $baseUrl . 'images/',
                'path'  => '@frontend/web' . $baseUrl . 'images/',
            ],
            'images-get'   => [
                'class' => GetAction::className(),
                'url'   => $baseUrl . 'images/',
                'path'  => '@frontend/web' . $baseUrl . 'images/',
                'type'  => GetAction::TYPE_IMAGES,
            ],
            'files-get'    => [
                'class' => GetAction::className(),
                'url'   => $baseUrl . 'files/',
                'path'  => '@frontend/web' . $baseUrl . 'files/',
                'type'  => GetAction::TYPE_FILES,
            ],
            'file-upload'  => [
                'class'           => UploadAction::className(),
                'url'             => $baseUrl . 'files/',
                'path'            => '@frontend/web' . $baseUrl . 'files/',
                'uploadOnlyImage' => false,
            ],
        ];
    }

}
