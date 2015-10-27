<?php

/* @var $this yii\web\View */
use frontend\modules\news\widgets\NewsCategoriesWidget;
use frontend\modules\news\widgets\NewsTagsWidget;
use frontend\modules\radiata\widgets\MetaTagsWidget;
use yii\widgets\LinkPager;

/* @var $category common\modules\news\models\NewsCategory */
/* @var $news common\modules\news\models\News[] */
/* @var $pages array */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('c/news', 'Module name'), 'url' => ['/news']];
$this->params['breadcrumbs'][] = $category->title;

MetaTagsWidget::widget(['item' => $category]);
?>

<section class="container">
    <div class="center">
        <h2><?= $category->title ?></h2>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <?
                foreach ($news as $newsItem) {
                    echo $this->render('_news', ['news' => $newsItem]);
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
            <aside class="col-md-4">
                <?= NewsCategoriesWidget::widget(['parent_id' => $category->id]) ?>
                <?= NewsTagsWidget::widget() ?>
            </aside>
        </div>
        <!--/.row-->
    </div>
</section><!--/#blog-->