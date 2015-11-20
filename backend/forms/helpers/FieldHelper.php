<?php
namespace backend\forms\helpers;

use backend\forms\widgets\LangInputWidget;
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

    public static function buildVoteOption($form, $modelOption, $isHidden = false)
    {
        $lines = [];
        $lines[] = '<div class="' . ($isHidden ? 'option-template hidden ' : '') . 'form-group">';
        $lines[] = '<div class="vote-option row">';
        $lines[] = '<div class="col-sm-11">';
        $lines[] = $form->field($modelOption, ($isHidden ? '[NEW_IND]' : '[' . $modelOption->id . ']') . 'title')->widget(LangInputWidget::classname(), [
            'options' => [
                'type' => 'activeTextInput',
            ],
        ]);
        $lines[] = '</div>';
        $lines[] = '<div class="col-sm-1">';
        $lines[] = '<button class="button-delete-option' . ($isHidden ? ' ' : '-exists') . ' btn btn-default" type="button"' . ($isHidden ? ' ' : 'data-option-id="' . $modelOption->id . '"') . '><i class="fa fa-fw fa-trash-o"></i></button>';
        $lines[] = '</div>';
        $lines[] = '</div>';
        $lines[] = '</div>';

        return join("\n", $lines);
    }

    public static function getDateFromTimestamp($date, $format)
    {
        if(strpos($date, '/') === false) {
            return date(Yii::t('c/radiata/settings', $format), $date);
        } else {
            return $date;
        }
    }
}