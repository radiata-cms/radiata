<?php
/**
 * Vote module
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\vote;

use common\modules\radiata\interfaces\RadiataModuleInterface;
use Yii;
use yii\helpers\Url;

/**
 * Class Vote
 */
class Vote extends \yii\base\Module implements RadiataModuleInterface
{
    /**
     * @var string Version
     */
    const VERSION = '0.1.0';

    /**
     * @var string Version
     */
    const BACKEND_PERMISSION = 'Votes Module';

    public function getModuleIcon()
    {
        return 'fa fa-question-circle';
    }

    public function getModuleMessages()
    {
        return 'c/vote';
    }

    public function getPublic()
    {
        return true;
    }

    /**
     * Backend navigation menu for module
     *
     * @return array
     */
    public function getBackendNavigation()
    {
        return [
            [
                'title'      => Yii::t($this->moduleMessages, 'Module name'),
                'icon'       => $this->moduleIcon,
                'link'       => Url::to(['/vote/vote/index']),
                'permission' => self::BACKEND_PERMISSION,
                'isModule'   => true,
            ],
        ];
    }
}
