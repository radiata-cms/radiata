<?php
namespace backend\forms;

use backend\forms\helpers\AuthHelper;
use backend\forms\helpers\FieldHelper;
use yii\base\Exception;
use yii\bootstrap\ActiveField;
use yii\helpers\Html;


class RadiataField extends ActiveField
{

    /**
     * Renders a date range input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return $this the field object itself
     */
    public function dateRangeInput($options = [])
    {
        if(isset($options['class'])) {
            $options['class'] = $this->inputOptions['class'] . ' ' . $options['class'];
        }

        $options = array_merge($this->inputOptions, $options);
        $options['class'] .= ' daterange-object';
        $this->adjustLabelFor($options);

        $input = '';
        $input .= '<div class="input-group">';
        $input .= '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
        $input .= Html::activeTextInput($this->model, $this->attribute, $options);
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

    /**
     * Renders a datetime input.
     *
     * @return $this the field object itself
     */
    public function dateTimeInput($options = [])
    {
        if(isset($options['class'])) {
            $options['class'] = $this->inputOptions['class'] . ' ' . $options['class'];
        }

        $options = array_merge($this->inputOptions, $options);
        $options['class'] .= ' datetime-object';
        $this->adjustLabelFor($options);

        $this->model->setAttributes([$this->attribute => FieldHelper::getDateFromTimestamp($this->model['attributes'][$this->attribute], 'dateTimePHPFormat')]);

        $input = '';
        $input .= '<div class="input-group">';
        $input .= '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
        $input .= Html::activeTextInput($this->model, $this->attribute, $options);
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

    /**
     * Renders a date input.
     *
     * @return $this the field object itself
     */
    public function dateInput($options = [])
    {
        if(isset($options['class'])) {
            $options['class'] = $this->inputOptions['class'] . ' ' . $options['class'];
        }

        $options = array_merge($this->inputOptions, $options);
        $options['class'] .= ' date-object';
        $this->adjustLabelFor($options);

        $this->model['attributes'][$this->attribute] = FieldHelper::getDateFromTimestamp($this->model['attributes'][$this->attribute], 'datePHPFormat');

        $input = '';
        $input .= '<div class="input-group">';
        $input .= '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
        $input .= Html::activeTextInput($this->model, $this->attribute, $options);
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

    /**
     * Renders a user roles input.
     *
     * @return $this the field object itself
     */
    public function userRolesInput()
    {
        $input = '';
        $input .= '<div class="html-tree">';
        $input .= AuthHelper::buildHtmlTreeInput($this->model, $this->attribute, AuthHelper::getRoles());
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

    /**
     * Renders a user permissions input.
     *
     * @return $this the field object itself
     */
    public function userPermissionsInput()
    {
        $input = '';
        $input .= '<div class="html-tree">';
        $input .= AuthHelper::buildHtmlTreeInput($this->model, $this->attribute, AuthHelper::getPermissions());
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

    /**
     * Renders a tree input.
     *
     * @return $this the field object itself
     */
    public function treeInput($options = [])
    {
        if(!$options['class']) {
            throw new Exception('Class name is missed');
        }

        $object = new $options['class'];
        $data = $object->getTreeData('')['children'];

        $input = '';
        $input .= '<div class="html-tree">';
        $input .= FieldHelper::buildHtmlTreeInput($this->model, $this->attribute, $data);
        $input .= '</div>';

        $this->parts['{input}'] = $input;

        return $this;
    }

}