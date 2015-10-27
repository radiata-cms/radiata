<?php
/* @var $this yii\web\View */
/* @var $news common\modules\news\models\News */
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="blog-item">
    <div class="row">
        <div class="col-xs-12 col-sm-2 text-center">
            <div class="entry-meta">
                <span id="publish_date"><?= Yii::$app->formatter->asDate($news->date, 'php: j M H:i') ?></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-10 blog-content">
            <? if(!empty($news->image)) { ?>
                <a href="<?= Url::to(['/news/news/view', 'slug' => $news->slug]); ?>">
                    <?= Html::img($news->getThumbFileUrl('image', 'big'), ['class' => 'img-responsive img-blog', 'alt' => $news->image_description, 'width' => '100%']) ?>
                </a>
                <? if($news->image_description) { ?>
                    <p>
                        <small><?= $news->image_description ?></small>
                    </p>
                <? } ?>
            <? } ?>

            <h2><?= Html::a($news->title, ['/news/news/view', ['slug' => $news->slug]]); ?></h2>

            <h3><?= $news->description; ?></h3>
            <a class="btn btn-primary readmore" href="<?= Url::to(['/news/news/view', 'slug' => $news->slug]); ?>"><?= Yii::t('f/news', 'Read More') ?>
                <i class="fa fa-angle-right"></i></a>
        </div>
    </div>
</div><!--/.blog-item-->