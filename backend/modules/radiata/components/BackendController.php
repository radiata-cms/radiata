<?php
namespace backend\modules\radiata\components;

use Yii;

class BackendController extends \yii\web\Controller
{
    public $accessPermission = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->layout = Yii::$app->getModule('radiata')->backendLayout;
    }

}