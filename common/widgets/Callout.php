<?php
namespace common\widgets;

class Callout extends \yii\bootstrap\Widget
{
    public $alertTypes = [
        'error'   => 'callout-danger',
        'danger'  => 'callout-danger',
        'success' => 'callout-success',
        'info'    => 'callout-info',
        'warning' => 'callout-warning'
    ];

    public $message;

    public $title;

    public $type;

    public function init()
    {
        parent::init();

        echo '<div class="callout ' . $this->alertTypes[$this->type] . '">
                ' . ($this->title ? '<h4>' . $this->title . '</h4>' : '') . '
                <p>' . $this->message . '</p>
              </div>';
    }
}
