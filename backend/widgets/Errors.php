<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Errors extends Widget
{
    public $encode = false;

    public $models = [];

    public $errorClass = 'has-error';


    /**
     * Renders the errors
     */
    public function run()
    {
        $lines = [];

        if(count($this->models) > 0) {
            $lines[] = '<div class="' . $this->errorClass . '">';
            foreach ($this->models as $model) {
                /* @var $model \yii\base\Model */
                foreach ($model->getFirstErrors() as $error) {
                    $lines[] = '<div class="form-group has-error"><label><i class="fa fa-times-circle-o"></i> ' . ($this->encode ? Html::encode($error) : $error) . '</label></div>';
                }
            }
            $lines[] = '</div>';
        }

        return implode("\n", $lines);
    }
}