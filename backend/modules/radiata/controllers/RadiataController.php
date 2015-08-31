<?php
namespace backend\modules\radiata\controllers;

use Yii;
use backend\modules\radiata\components\BackendController;
use common\models\LoginForm;
use yii\helpers\Url;

/**
 * Radiata controller
 */
class RadiataController extends BackendController
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['error', 'login'])) {
            $this->layout = 'forbidden';
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(Yii::$app->request->pathInfo);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
