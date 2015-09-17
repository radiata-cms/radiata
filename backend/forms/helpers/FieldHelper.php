<?php
namespace backend\forms\helpers;

use Yii;

class FieldHelper
{

    public static function getDateFromRange($date)
    {
        if(preg_match("/([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4}) \\- ([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4})/", $date, $mm)) {
            $from = strtotime($mm[1]);
            $to = strtotime($mm[2]) + 3600 * 24;
        } else {
            $from = null;
            $to = null;
        }

        return [$from, $to];
    }
}