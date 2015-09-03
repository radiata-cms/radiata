<?php
namespace backend\modules\radiata\events;

use Yii;
use yii\base\Event;
use backend\modules\radiata\models\AdminLog;

class AdminLogEvent extends Event
{

    const EVENT_WRONG_AUTH = 'wrongAuth';

    const EVENT_SUCCESS_AUTH = 'successAuth';

    const EVENT_CREATE_ITEM = 'createItem';

    const EVENT_UPDATE_ITEM = 'updateItem';

    const EVENT_DELETE_ITEM = 'deleteItem';

    public function wrongAuth($event)
    {
        AdminLogEvent::saveEvent($event, 'wrongAuth', $event->sender->module->module->request->post('LoginForm')['username']);
    }

    public function successAuth($event)
    {
        AdminLogEvent::saveEvent($event, 'successAuth', $event->sender->module->module->request->post('LoginForm')['username']);
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
            if (isset($event->sender->attributes[$event->data])) {
                $adminLog->data = $event->sender->attributes[$event->data];
            }
        } else {
            $adminLog->data = $data;
        }

        $adminLog->action = $action;
        $adminLog->user_id = Yii::$app->user->getId();

        if ($adminLog->save()) {
            //ok
        }
    }
}