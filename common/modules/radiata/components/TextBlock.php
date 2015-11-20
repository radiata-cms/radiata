<?php
namespace common\modules\radiata\components;

use Yii;
use yii\base\Component;

class TextBlock extends Component
{
    public function v($name, $key = '')
    {
        return \common\modules\radiata\models\TextBlock::getBlockData($name, $key);
    }
}
