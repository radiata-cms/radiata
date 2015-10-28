<?php
use frontend\modules\radiata\widgets\GalleryWidget;
use frontend\modules\radiata\widgets\MetaTagsWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $news common\modules\news\models\News */
/* @var $this yii\web\View */

$this->title = $news->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('c/news', 'Module name'), 'url' => ['/news']];
$this->params['breadcrumbs'][] = $news->title;

MetaTagsWidget::widget(['item' => $news]);
?>
<section id="blog" class="container">
    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-item">
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
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 text-center">
                            <div class="entry-meta">
                                <span id="publish_date"><?= Yii::$app->formatter->asDate($news->date, 'php: j M H:i') ?></span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 blog-content">
                            <h2><?= $news->title ?></h2>
                            <?= $news->description ? '<p>' . $news->description . '</p>' : ''; ?>
                            <?= $news->content; ?>
                            <? if(!empty($news->tags)) { ?>
                                <div class="post-tags">
                                    <strong>Tags:</strong>
                                    <?
                                    $flag = false;
                                    foreach ($news->tags as $tag) {
                                        ?>
                                        <?= $flag ? ' / ' : '' ?><?= Html::a($tag->name, ['/news/tag/view', 'name' => $tag->name]) ?>
                                        <?
                                        $flag = true;
                                    }
                                    ?>
                                </div>
                            <? } ?>
                            <?= GalleryWidget::widget(['gallery' => $news->gallery]) ?>
                        </div>
                    </div>
                </div>
                <!--/.blog-item-->
            </div>
            <!--/.col-md-8-->

            <? echo $this->render('/news/_right', ['category' => $news->category]); ?>

        </div>
        <!--/.row-->

    </div>
    <!--/.blog-->

</section><!--/#blog-->