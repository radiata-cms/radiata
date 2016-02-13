<?
/* @var $this \yii\web\View */
/* @var $id string */
/* @var $sectionClass string */
/* @var $slides common\modules\slider\models\Slide[] */

use frontend\modules\slider\assets\SliderAsset;

SliderAsset::register($this);

?>

<section id="<?= $id ?>" <?= $sectionClass ? ' class="' . $sectionClass . '"' : '' ?>>
    <div class="carousel slide">
        <ol class="carousel-indicators">
            <?
            $isActive = true;
            foreach ($slides as $key => $slide) {
                echo '<li data-target="#' . $id . '" data-slide-to="' . $key . '"' . ($isActive ? ' class="active"' : '') . '></li>';
                $isActive = false;
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?
            $isActive = true;
            foreach ($slides as $key => $slide) {
                ?>
                <div class="item <?= ($isActive ? ' active' : '') ?>" style="background-image: url(<?= $slide->getThumbFileUrl('image', 'slide') ?>)">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-12">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1"><?= $slide->title ?></h1>

                                    <h2 class="animation animated-item-2"><?= $slide->description ?></h2>
                                    <? if($slide->link) { ?>
                                        <a class="btn-slide animation animated-item-3" href="<?= $slide->link ?>"><?= Yii::t('c/radiata', 'Read More') ?></a>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?
                $isActive = false;
            }
            ?>
        </div>
        <!--/.carousel-inner-->
    </div>
    <!--/.carousel-->
    
    <? if(count($slides) > 1) { ?>
        <a class="prev hidden-xs" href="#<?= $id ?>" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
        <a class="next hidden-xs" href="#<?= $id ?>" data-slide="next"><i class="fa fa-chevron-right"></i></a>
    <? } ?>
</section><!--/#main-slider-->
