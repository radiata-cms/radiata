<?php
namespace backend\modules\radiata\events;

use Yii;
use yii\base\Event;
use common\models\user\User;
use backend\modules\radiata\models\AdminLog;

class AdminLogEvent extends Event
{

    const EVENT_WRONG_AUTH = 'wrongAuth';

    const EVENT_SUCCESS_AUTH = 'successAuth';

    const EVENT_WRONG_AUTH_LOCK_SCREEN = 'wrongAuthLockScreen';

    const EVENT_SUCCESS_AUTH_LOCK_SCREEN = 'successAuthLockScreen';

    const EVENT_CREATE_ITEM = 'createItem';

    const EVENT_UPDATE_ITEM = 'updateItem';

    const EVENT_DELETE_ITEM = 'deleteItem';

    public function wrongAuth($event)
    {
        $value = $event->sender->module->module->request->post('LoginForm')['email'];
        $user = User::findByEmail($value);

        AdminLogEvent::saveEvent($event, 'wrongAuth', $user ? $user->email : $value);
    }

    public function successAuth($event)
    {
        $value = $event->sender->module->module->request->post('LoginForm')['email'];
        $user = User::findByEmail($value);

        AdminLogEvent::saveEvent($event, 'successAuth', $user ? $user->email : $value);
    }

    public function wrongAuthLockScreen($event)
    {
        $value = $event->sender->module->module->request->post('LockScreenLoginForm')['user_id'];
        $user = User::findById($value);

        AdminLogEvent::saveEvent($event, 'wrongAuthLockScreen', $user ? $user->email : $value);
    }

    public function successAuthLockScreen($event)
    {
        $value = $event->sender->module->module->request->post('LockScreenLoginForm')['user_id'];
        $user = User::findById($value);

        AdminLogEvent::saveEvent($event, 'successAuthLockScreen', $user ? $user->email : $value);
    }

    public function createItem($event)
    {
        AdminLogEvent::saveEvent($event, 'createItem');
    }

    public function updateItem($event)
    {
        AdminLogEvent::saveEvent($event, 'updateItem');
    }

    public function deleteItem($event)
    {
        AdminLogEvent::saveEvent($event, 'deleteItem');
    }

    public static function saveEvent($event, $action, $data = '')
    {
        $adminLog = new AdminLog();
        $adminLog->module = Yii::$app->controller->module->id;

        if (get_parent_class($event->sender) == 'yii\db\ActiveRecord') {
            $adminLog->model = get_class($event->sender);
            if(isset($event->sender->attributes[$event->data['title']])) {
                $adminLog->data = $event->sender->attributes[$event->data['title']];
            }
        } else {
            $adminLog->data = $data;
        }

        $adminLog->icon = $event->data['icon'];
        $adminLog->action = $action;
        $adminLog->user_id = Yii::$app->user->getId();

        $adminLog->save();
    }
}