<?php
namespace backend\forms\helpers;

use Yii;
use yii\helpers\Html;

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

    public static function showErrors($model)
    {
        $errors = '';
        if($model->hasErrors()) {
            $errors .= '<div class="callout callout-danger">';
            $errors .= '<h4>' . Yii::t('yii', 'Please fix the following errors:') . '</h4>';
            foreach ($model->getErrors() as $error) {
                foreach ($error as $suberror) {
                    $errors .= '<p>- ' . $suberror . '</p>';
                }
            }
            $errors .= '</div>';
        }

        return $errors;
    }

    public static function buildHtmlTreeInput($model, $attribute, $data)
    {
        $lines = [];
        if(is_array($data) && count($data) > 0) {
            $lines[] = '<ul>';
            foreach ($data as $k => $v) {
                $lines[] = '<li>';
                $lines[] = '<div class="checkbox icheck">';
                $lines[] = Html::checkbox(Html::getInputName($model, $attribute) . '[' . $v['id_pure'] . ']', in_array($v['id_pure'], $model->$attribute), [
                    'value' => $v['id_pure'],
                    'label' => '<span>' . $v['text'] . '</span>',
                ]);
                $lines[] = '</div>';

                if(is_array($v['children'])) {
                    $lines[] = self::buildHtmlTreeInput($model, $attribute, $v['children']);
                }
                $lines[] = '</li>';
            }
            $lines[] = '</ul>';
        }

        return join("\n", $lines);
    }
}