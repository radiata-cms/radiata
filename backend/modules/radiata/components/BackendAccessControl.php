<?php
namespace backend\modules\radiata\components;

use Yii;
use yii\web\User;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;

class BackendAccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     * @var array List of action that not need to check access.
     */
    public $allowedActions = [];

    /**
     * @var array List of action that not need to check access when logged in.
     */
    public $allowedActionsLoggedIn = [];

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $user = $this->getUser();

            if (in_array($action->getUniqueId(), $this->allowedActions)) {
                return true;
            } elseif ($user->isGuest) {
                return Yii::$app->response->redirect(['radiata/login']);
            } elseif (in_array($action->getUniqueId(), $this->allowedActionsLoggedIn)) {
                return true;
            }

            $userGroups = Yii::$app->authManager->getAssignments($user->id);
            if (isset($userGroups['admin'])) {

                // full access

            } elseif (isset($userGroups['manager'])) {

                if ($user->can($action->controller->module)) {
                    return true;
                }

            } else {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }

        return true;
    }
}