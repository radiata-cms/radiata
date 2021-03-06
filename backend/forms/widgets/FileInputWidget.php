<?php
namespace backend\forms\widgets;

use backend\modules\radiata\behaviors\FileUploadBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class FileInputWidget extends \yii\widgets\InputWidget
{
    public $options = [];

    public $pluginOptions = [];

    public function run()
    {
        $options = $this->options;

        $pluginOptions = ArrayHelper::merge([
            'showUpload' => false,
            'dropZoneEnabled' => false,
            'browseClass' => 'btn btn-success',
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
        ], $this->pluginOptions);

        $model = $this->model;
        $attribute = $this->attribute;
        $imageInputId = Html::getInputId($this->model, $this->attribute);
        $imageDeletedInputId = $attribute . FileUploadBehavior::DELETED_PREFIX;

        return $this->render('FileInput', compact('options', 'pluginOptions', 'model', 'attribute', 'imageInputId', 'imageDeletedInputId'));
    }
}