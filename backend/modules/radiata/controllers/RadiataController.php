<?php
namespace backend\modules\radiata\controllers;

use backend\modules\radiata\components\BackendController;
use backend\modules\radiata\events\AdminLogEvent;
use backend\modules\radiata\models\LockScreenLoginForm;
use common\models\user\LoginForm;
use common\models\user\User;
use common\modules\radiata\components\Migrator;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Radiata controller
 */
class RadiataController extends BackendController
{
    const BACKEND_PERMISSION = 'Radiata Module. Dashboard';

    public function init()
    {
        parent::init();

        $this->on(AdminLogEvent::EVENT_WRONG_AUTH, [AdminLogEvent::className(), 'wrongAuth']);
        $this->on(AdminLogEvent::EVENT_SUCCESS_AUTH, [AdminLogEvent::className(), 'successAuth']);
    }

    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['applyMigrations'],
                'rules' => [
                    [
                        'allow' => true,
                        'ajax' => true,
                    ],
                ],
            ],
        ];
    }
    */

    public function beforeAction($action)
    {
        if(in_array($action->id, ['login'])) {
            $this->layout = 'forbidden';
        } elseif(in_array($action->id, ['error']) && Yii::$app->errorHandler->exception->statusCode == 403) {
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
        if(!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if($model->load(Yii::$app->request->post())) {
            if($model->login()) {
                $this->trigger(AdminLogEvent::EVENT_SUCCESS_AUTH);

                return $this->goBack(Yii::$app->request->pathInfo);
            } else {
                $this->trigger(AdminLogEvent::EVENT_WRONG_AUTH);
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionLockScreen($id)
    {
        if(!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $user = User::findOne($id);

        if($user) {
            $successLogin = false;
            $model = new LockScreenLoginForm();
            if($model->load(Yii::$app->request->post())) {
                if($model->login()) {
                    $this->trigger(AdminLogEvent::EVENT_SUCCESS_AUTH);
                    $successLogin = true;
                } else {
                    $this->trigger(AdminLogEvent::EVENT_WRONG_AUTH);
                }
            }

            return $this->renderAjax('lock-screen', ['user' => $user, 'model' => $model, 'successLogin' => $successLogin]);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    public function actionApplyMigrations()
    {
        if(Yii::$app->request->isAjax) {
            $migrator = new Migrator();
            $migrator->migrate();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $result = [];
            if($migrator->error) {
                $result['error'] = $migrator->error->getMessage();
            } else {
                $result['success'] = Yii::t('b/radiata/common', 'Migrations were applied successfully');
            }

            return $result;
        }
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
