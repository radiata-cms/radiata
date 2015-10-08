<?php
namespace backend\forms;

use backend\modules\radiata\helpers\RadiataHelper;
use Yii;
use yii\validators\DateValidator;
use yii\validators\Validator;

class DateTimeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $error = false;
        $dateValidator = new DateValidator();

        if(preg_match("/([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4}) ([0-9]{2}:[0-9]{2})/", $model->$attribute, $mm)) {
            if(!$dateValidator->validateValue($mm[1]) || !RadiataHelper::validateTime($mm[2])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        if($error) {
            $this->addError($model, $attribute, Yii::t('b/radiata/forms', 'DateTime format error'));
        }
    }
}