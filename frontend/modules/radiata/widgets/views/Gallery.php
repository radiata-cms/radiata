<?
/* @var $this \yii\web\View */
/* @var $gallery array */

use frontend\modules\radiata\assets\GalleryAsset;
use yii\helpers\Html;

GalleryAsset::register($this);
?>

<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">
    <div class="rg-image-wrapper">
        {{if itemsCount > 1}}
            <div class="rg-image-nav">
                <a href="#" class="rg-image-nav-prev">Previous Image</a>
                <a href="#" class="rg-image-nav-next">Next Image</a>
            </div>
        {{/if}}
        <div class="rg-image"></div>
        <div class="rg-loading"></div>
        <div class="rg-caption-wrapper">
            <div class="rg-caption" style="display:none;">
                <p></p>
            </div>
        </div>
    </div>

</script>
<div id="rg-gallery" class="rg-gallery">
    <div class="rg-thumbs">
        <div class="es-carousel-wrapper">
            <div class="es-nav">
                <span class="es-nav-prev">Previous</span>
                <span class="es-nav-next">Next</span>
            </div>
            <div class="es-carousel">
                <ul>
                    <? foreach ($gallery as $galleryItem) { ?>
                        <li>
                            <a href="#"><img src="<?= $galleryItem->getThumbFileUrl('image', 'small') ?>" data-large="<?= $galleryItem->getThumbFileUrl('image', 'big') ?>" alt="" data-description="<?= Html::encode($galleryItem->image_text) ?>"/></a>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- rg-thumbs -->
</div><!-- rg-gallery -->
