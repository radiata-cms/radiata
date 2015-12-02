<?php
namespace backend\modules\radiata\components;

use Yii;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class BackendAccessControl extends \yii\base\ActionFilter
{
    /**
     * @var array List of action that not need to check access.
     */
    public $allowedActions = [];
    /**
     * @var array List of action that not need to check access when logged in.
     */
    public $allowedActionsLoggedIn = [];
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    public static function checkPermissionAccess($permission, $userId = '')
    {
        if(Yii::$app->user->isGuest) {
            return false;
        }

        if(!$userId) {
            $userId = Yii::$app->user->identity->getId();
        }

        if(self::checkFullAccess($userId)) {
            return true;
        } else {
            return Yii::$app->user->can($permission);
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action)) {
            $user = $this->getUser();

            if(in_array($action->getUniqueId(), $this->allowedActions)) {
                return true;
            } elseif($user->isGuest) {
                Yii::$app->response->redirect(['/radiata/login'])->send();

                return false;
            } elseif(in_array($action->getUniqueId(), $this->allowedActionsLoggedIn)) {
                return true;
            }

            $userGroups = Yii::$app->authManager->getAssignments($user->id);
            if(self::checkFullAccess()) {

                return true;

            } elseif(isset($userGroups['manager'])) {

                if($action->controller->id == 'radiata' && isset($userGroups['manager'])) {
                    return true;
                } elseif(defined(get_class($action->controller) . '::BACKEND_PERMISSION') && $user->can(constant(get_class($action->controller) . '::BACKEND_PERMISSION'))) {
                    return true;
                } elseif(!defined(get_class($action->controller) . '::BACKEND_PERMISSION') && defined(get_class($action->controller->module) . '::BACKEND_PERMISSION') && $user->can(constant(get_class($action->controller->module) . '::BACKEND_PERMISSION'))) {
                    return true;
                } else {
                    throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
                }

            } else {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }

        return false;
    }

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if(!$this->_user instanceof User) {
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

    public static function checkFullAccess($userId = '')
    {
        return (self::checkRoleAccess('admin', $userId) || self::checkRoleAccess('developer', $userId));
    }

    public static function checkRoleAccess($role, $userId = '')
    {
        if(Yii::$app->user->isGuest) {
            return false;
        }

        if(!$userId) {
            $userId = Yii::$app->user->identity->getId();
        }
        $userGroups = Yii::$app->authManager->getAssignments($userId);

        return isset($userGroups[$role]);
    }
}