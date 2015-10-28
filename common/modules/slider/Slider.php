<?php
/**
 * Slider module
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\slider;

use common\modules\radiata\interfaces\RadiataModuleInterface;
use Yii;
use yii\helpers\Url;

/**
 * Class Slider
 */
class Slider extends \yii\base\Module implements RadiataModuleInterface
{
    /**
     * @var string Version
     */
    const VERSION = '0.1.0';

    /**
     * @var string Version
     */
    const BACKEND_PERMISSION = 'Sliders Module';

    public function getModuleIcon()
    {
        return 'fa fa-sliders';
    }

    public function getModuleMessages()
    {
        return 'c/slider';
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
                'link'       => Url::to(['slider/slider/index']),
                'permission' => self::BACKEND_PERMISSION,
                'isModule'   => true,
                'children'   => [

                    [
                        'title'           => Yii::t('b/slider', 'Sliders'),
                        'icon'            => 'fa fa-sliders',
                        'link'            => Url::to(['/slider/slider/index']),
                        'permission'      => self::BACKEND_PERMISSION,
                        'isActiveUrlPart' => '/slider/slider/',
                    ],
                    [
                        'title'           => Yii::t('b/slider/slide', 'Slides'),
                        'icon'            => 'fa fa-sticky-note-o',
                        'link'            => Url::to(['/slider/slide/index']),
                        'permission'      => self::BACKEND_PERMISSION,
                        'isActiveUrlPart' => '/slider/slide/',
                    ],
                ],
            ],
        ];
    }
}
