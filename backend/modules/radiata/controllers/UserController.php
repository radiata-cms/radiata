<?php

namespace backend\modules\radiata\controllers;

use Yii;
use common\models\user\User;
use common\models\user\UserSearch;
use backend\modules\radiata\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BackendController
{
    const BACKEND_PERMISSION = 'Radiata Module. Users';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => User::SCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        $transaction = Yii::$app->db->beginTransaction();
        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->setPassword($user->new_password);
            $user->generateAuthKey();
            if ($user->save()) {

                $user->saveUserRbac($user);

                $transaction->commit();

                return $this->redirect(['view', 'id' => $user->id]);
            } else {
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $user,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);

        $user->scenario = User::SCENARIO_UPDATE;

        if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        $transaction = Yii::$app->db->beginTransaction();
        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            if ($user->new_password) {
                $user->setPassword($user->new_password);
            }
            if ($user->save()) {

                $user->saveUserRbac($user);

                $transaction->commit();

                return $this->redirect(['view', 'id' => $user->id]);
            } else {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                'model' => $user,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::makeUser(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
