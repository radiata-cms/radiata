<?php
namespace frontend\modules\slider\widgets;

use common\modules\slider\models\Slide;
use common\modules\slider\models\Slider;
use Yii;
use yii\base\Exception;

class SliderWidget extends \yii\bootstrap\Widget
{
    public $id;

    public $sectionClass;

    public $slider_id;

    public function run()
    {
        if(!$this->id) {
            throw new Exception('Slider ID is missing');
        }

        $slider = Slider::findOne($this->slider_id);
        if($slider) {
            $slides = Slide::find()->active()->where(['slider_id' => $this->slider_id])->language()->order()->all();

            if(!empty($slides)) {
                return $this->render('Slider', [
                    'id'           => $this->id,
                    'sectionClass' => $this->sectionClass,
                    'slides'       => $slides,
                ]);
            } else {
                return '';
            }
        }

        return '';
    }
}

