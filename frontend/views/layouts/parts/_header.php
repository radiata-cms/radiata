<?
/* @var $this \yii\web\View */
/* @var $content string */

use common\modules\radiata\widgets\LangSwitcherWidget;
use frontend\modules\radiata\widgets\NavBarWidget;
use frontend\modules\radiata\widgets\TextBlockWidget;

?>
<header id="header">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-4">
                    <div class="top-number"><p><i class="fa fa-phone-square"></i> +0123 456 70 90</p></div>
                </div>
                <div class="col-sm-6 col-xs-8">
                    <div class="social">
                        <?
                        /**
                         * @var array $socialData
                         */
                        $socialData = TextBlockWidget::begin(['name' => 'socials']);
                        if(!empty($socialData)) {
                            ?>
                            <ul class="social-share">
                                <? foreach ($socialData as $icon => $link) { ?>
                                    <li>
                                        <a href="<?= $link ?>" target="_blank" rel="nofollow"><i class="fa fa-<?= $icon ?>"></i></a>
                                    </li>
                                <? } ?>
                            </ul>
                        <?
                        }
                        TextBlockWidget::end();
                        ?>
                        <? /*
                        <div class="search">
                            <form role="form">
                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                <i class="fa fa-search"></i>
                            </form>
                        </div>
                        */ ?>
                        <?= LangSwitcherWidget::widget(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.top-bar-->

    <?= NavBarWidget::widget(); ?>
</header><!--/header-->
