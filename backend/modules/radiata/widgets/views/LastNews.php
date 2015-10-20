<?php
/* @var $this yii\web\View */
/* @var $news common\modules\news\models\News[] */

use backend\modules\radiata\helpers\RadiataHelper;
use yii\helpers\Html;

?>

<div class="col-md-8 connectedSortable">
    <!-- PRODUCT LIST -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('b/news', 'Recently Added News') ?></h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="products-list product-list-in-box">
                <?
                foreach ($news as $newsItem) {
                    ?>
                    <li class="item">
                        <div class="product-img">
                            <?= Html::a(Html::img($newsItem->getThumbFileUrl('image', 'small')), ['/news/news/view', 'id' => $newsItem->id]) ?>
                        </div>
                        <div class="product-info">
                            <?= Html::a($newsItem->title, ['/news/news/view/', 'id' => $newsItem->id], ['class' => 'product-title']) ?>
                            <span class="product-description"><?= RadiataHelper::outputCleanValue($newsItem->description) ?></span>
                        </div>
                    </li>
                <?
                }
                ?>
            </ul>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
            <?= Html::a(Yii::t('b/news', 'View All News'), ['/news/news/index'], ['class' => 'uppercase']) ?>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>