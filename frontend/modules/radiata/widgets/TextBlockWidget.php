<?php
namespace frontend\modules\radiata\widgets;

use common\modules\radiata\models\TextBlock;
use Yii;

class TextBlockWidget extends \yii\bootstrap\Widget
{
    public $name = '';

    public $key = '';

    /**
     * @inheritdoc
     */
    public static function begin($config = [])
    {
        return TextBlock::getBlockData($config['name'], $config['key']);
    }

    /**
     * @inheritdoc
     */
    public static function end()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return TextBlock::getBlockData($this->name, $this->key);
    }
}

