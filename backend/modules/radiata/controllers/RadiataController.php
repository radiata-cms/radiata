<?php
namespace backend\modules\radiata\controllers;

use Yii;
use backend\modules\radiata\components\BackendController;
use common\models\LoginForm;
use common\models\User;
use backend\modules\radiata\models\LockScreenLoginForm;
use backend\modules\radiata\events\AdminLogEvent;
use yii\web\ForbiddenHttpException;

/**
 * Radiata controller
 */
class RadiataController extends BackendController
{
    public function init()
    {
        parent::init();

        $this->on(AdminLogEvent::EVENT_WRONG_AUTH, [AdminLogEvent::className(), 'wrongAuth']);
        $this->on(AdminLogEvent::EVENT_SUCCESS_AUTH, [AdminLogEvent::className(), 'successAuth']);
    }

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
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
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
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $user = User::findOne($id);

        if ($user) {
            $successLogin = false;
            $model = new LockScreenLoginForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->login()) {
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
