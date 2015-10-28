<?php
use frontend\modules\radiata\widgets\MetaTagsWidget;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $tag common\modules\news\models\NewsTag */
/* @var $news common\modules\news\models\News[] */
/* @var $pages array */

$this->title = $tag->name;
$this->params['breadcrumbs'][] = Yii::t('c/news', 'Tags');
$this->params['breadcrumbs'][] = $tag->name;

MetaTagsWidget::widget(['type' => 'tag', 'item' => $tag]);
?>

<section class="container">
    <div class="center">
        <h2><?= $tag->name ?></h2>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <?
                foreach ($news as $newsItem) {
                    echo $this->render('/news/_news', ['news' => $newsItem]);
                }

                echo LinkPager::widget([
                    'pagination'     => $pages,
                    'maxButtonCount' => 5,
                    'prevPageLabel'  => '<i class="fa fa-long-arrow-left"></i>',
                    'nextPageLabel'  => '<i class="fa fa-long-arrow-right"></i>',
                    'options'        => [
                        'class' => 'pagination pagination-lg',
                    ],
                ]);
                ?>
            </div>
            <? echo $this->render('/news/_right'); ?>
        </div>
        <!--/.row-->
    </div>
</section>