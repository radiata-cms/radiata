<?php
namespace backend\forms\widgets;

use Yii;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

class GalleryInputWidget extends \yii\widgets\InputWidget
{
    public $form;

    public $className;

    public $options = [];

    public function run()
    {
        if(!($this->form instanceof ActiveForm)) {
            throw new Exception('Form must be provided');
        }

        $options = $this->options;
        $model = $this->model;
        $attribute = $this->attribute;
        $form = $this->form;
        $className = $this->className;

        $initialPreview = [];
        $initialPreviewConfig = [];
        $initialPreviewThumbTag = [];

        if(is_array($model->$attribute)) {
            foreach ($model->$attribute as $k => $value) {
                $initialPreview[] = Html::img($value->getThumbFileUrl('image', 'small'));
                $initialPreviewConfig[] = [
                    'url' => Url::to(['news/gallery-delete-fake']),
                    'key' => $value->id
                ];
                $initialPreviewThumbTag[] = [
                    '{TAG_CSS_NEW}'     => 'hide',
                    '{TAG_CSS_INIT}'    => '',
                    '{CUSTOM_TAG_NEW}'  => '',
                    '{CUSTOM_TAG_INIT}' => '' . $form->field($value, '[' . $value->id . ']image_text')->widget(LangInputWidget::classname(), [
                            'options' => [
                                'type'                 => 'activeTextInput',
                                'additionalCssClasses' => 'kv-input kv-new form-control input-sm',
                            ],
                        ]),
                ];
            }
        }

        $newsGallery = new $className();

        $fieldName = (new \ReflectionClass($className))->getShortName();

        return $this->render('GalleryInput', compact('form', 'options', 'model', 'attribute', 'initialPreview', 'initialPreviewConfig', 'initialPreviewThumbTag', 'newsGallery', 'fieldName'));
    }
}