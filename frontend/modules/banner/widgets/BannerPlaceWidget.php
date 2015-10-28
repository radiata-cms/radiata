<?php
namespace frontend\modules\banner\widgets;

use common\modules\banner\models\Banner;
use common\modules\banner\models\BannerPlace;
use Yii;

class BannerPlaceWidget extends \yii\bootstrap\Widget
{
    public $place;

    public function run()
    {
        $bannerPlace = BannerPlace::findOne($this->place);
        if($bannerPlace) {

            $banners = Banner::find()->active()->language()->with('stat')->all();
            if(!empty($banners)) {
                $bannersSum = 0;
                foreach ($banners as $banner)
                    $bannersSum += $banner->priority;

                if($bannersSum > 0) {
                    $bannersRandNum = mt_rand(1, $bannersSum);
                    foreach ($banners as $banner) {
                        if($banner->priority > 0) {
                            $data = $banner;
                            $bannersRandNum = $bannersRandNum - $banner->priority;
                            if($bannersRandNum <= 0) {
                                break;
                            }
                        }
                    }
                } else {
                    $data = $banners[array_rand($banners)];
                }

                /** @var $data Banner */
                if(isset($data)) {
                    $data->addView();

                    return $this->render('BannerPlace', ['data' => $data]);
                } else {
                    return '';
                }
            }
        }
    }
}
