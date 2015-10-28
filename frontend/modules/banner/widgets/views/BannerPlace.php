<?
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $data common\modules\banner\models\Banner */
?>

<? if($data->html) { ?>
    <div class="row banner-place-<?= $data->place_id ?>">
        <div class="col-sm-12"><?= $data->html ?></div>
    </div>
<? } elseif($data->image) { ?>
    <div class="row banner-place-<?= $data->place_id ?>">
        <div class="col-sm-12">
            <?
            if ($data->link) {
            ?>
            <a href="<?= Url::to(['/banner/banner/click', 'id' => $data->id]) ?>"<? if($data->new_wnd) { ?> target="_blank"<? } ?>>
                <? } ?>
                <?= Html::img($data->getImageFileUrl('image')); ?>
                <?
                if ($data->link) {
                ?>
            </a>
        <? } ?>
        </div>
    </div>
<? } ?>