<?php
namespace backend\forms;

use Yii;
use yii\validators\Validator;
use yii\validators\DateValidator;

class DateRangeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $error = false;
        $dateValidator = new DateValidator();

        if (preg_match("/([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4}) \\- ([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4})/", $model->$attribute, $mm)) {
            if (!$dateValidator->validateValue($mm[1]) || !$dateValidator->validateValue($mm[2])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            $this->addError($model, $attribute, Yii::t('b/radiata/forms', 'DateRange format error'));
        }
    }
}