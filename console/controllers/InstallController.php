<?
namespace console\controllers;

use common\modules\banner\models\Banner;
use common\modules\banner\models\BannerPlace;
use common\modules\menu\models\Menu;
use common\modules\menu\models\MenuTranslation;
use common\modules\news\models\News;
use common\modules\news\models\NewsCategory;
use common\modules\news\models\NewsCategoryTranslation;
use common\modules\news\models\NewsGallery;
use common\modules\news\models\NewsGalleryTranslation;
use common\modules\news\models\NewsTag;
use common\modules\news\models\NewsTagTranslation;
use common\modules\news\models\NewsTranslation;
use common\modules\page\models\Page;
use common\modules\page\models\PageTranslation;
use common\modules\radiata\models\TextBlock;
use common\modules\radiata\models\TextBlockTranslation;
use common\modules\slider\models\Slide;
use common\modules\slider\models\Slider;
use common\modules\slider\models\SlideTranslation;
use common\modules\vote\models\Vote;
use common\modules\vote\models\VoteOption;
use common\modules\vote\models\VoteOptionTranslation;
use common\modules\vote\models\VoteTranslation;
use Yii;
use yii\helpers\FileHelper;

class InstallController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $migrator = new \common\modules\radiata\components\Migrator();
        $migrator->migrate();
        if($migrator->error) {
            print_r('Error: ' . $migrator->error);
        } else {
            echo 'Done!';
            Yii::$app->cache->flush();
        }
    }

    public function actionUninstall()
    {
        $migrator = new \common\modules\radiata\components\Migrator();
        $migrator->direction = "down";
        $migrator->migrate();
        if($migrator->error) {
            print_r('Error: ' . $migrator->error);
        } else {
            echo 'Done!';
            Yii::$app->cache->flush();
        }

        FileHelper::removeDirectory(Yii::getAlias('@frontend/web/uploads'));
    }

    public function actionFillData($data = '')
    {
        if(!$data) {
            $data = 'all';
        }

        if($data == 'textblock' || $data == 'all') {
            /* TextBlock */
            Yii::$app->db->createCommand()
                ->batchInsert(TextBlock::tableName(), ['name', 'key', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        ['counters', '', time(), time(), 1, 1], // 1
                        ['socials', 'facebook', time(), time(), 1, 1], // 2
                        ['socials', 'twitter', time(), time(), 1, 1], // 3
                        ['socials', 'linkedin', time(), time(), 1, 1], // 4
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(TextBlockTranslation::tableName(), ['parent_id', 'locale', 'text'],
                    [
                        ['1', 'en-US', '<!-- GA counter-->'],
                        ['1', 'ru-RU', '<!-- GA counter-->'],

                        ['2', 'en-US', 'http://www.facebook.com'],
                        ['2', 'ru-RU', 'http://www.facebook.com'],

                        ['3', 'en-US', 'http://twitter.com'],
                        ['3', 'ru-RU', 'http://twitter.com'],

                        ['4', 'en-US', 'https://www.linkedin.com'],
                        ['4', 'ru-RU', 'https://www.linkedin.com'],
                    ])
                ->execute();
        }

        if($data == 'news' || $data == 'all') {
            /* News categories */
            Yii::$app->db->createCommand()
                ->batchInsert(NewsCategory::tableName(), ['status', 'parent_id', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [NewsCategory::STATUS_ACTIVE, null, 1, time(), time(), 1, 1], // 1
                        [NewsCategory::STATUS_ACTIVE, null, 2, time(), time(), 1, 1], // 2
                        [NewsCategory::STATUS_ACTIVE, 1, 3, time(), time(), 1, 1], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(NewsCategoryTranslation::tableName(), ['parent_id', 'locale', 'slug', 'title'],
                    [
                        ['1', 'en-US', 'cat-1', 'Category 1'],
                        ['1', 'ru-RU', 'cat-1-ru', 'Category 1 Ru'],

                        ['2', 'en-US', 'cat-2', 'Category 2'],
                        ['2', 'ru-RU', 'cat-2-ru', 'Category 2 Ru'],

                        ['3', 'en-US', 'cat-3', 'Category 3'],
                        ['3', 'ru-RU', 'cat-3-ru', 'Category 3 Ru'],
                    ])
                ->execute();

            /* News tags */
            Yii::$app->db->createCommand()
                ->batchInsert(NewsTag::tableName(), ['frequency'],
                    [
                        ['1'], // 1
                        ['1'], // 2
                        ['1'], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(NewsTagTranslation::tableName(), ['parent_id', 'locale', 'name'],
                    [
                        ['1', 'en-US', 'Tag 1'],
                        ['1', 'ru-RU', 'Tag 1 Ru'],

                        ['2', 'en-US', 'Tag 2'],
                        ['2', 'ru-RU', 'Tag 2 Ru'],

                        ['3', 'en-US', 'Tag 3'],
                        ['3', 'ru-RU', 'Tag 3 Ru'],
                    ])
                ->execute();

            /* News */
            Yii::$app->db->createCommand()
                ->batchInsert(News::tableName(), ['date', 'category_id', 'status', 'image', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [time() - 2, '1', News::STATUS_ACTIVE, '1.jpg', time(), time(), 1, 1], // 1
                        [time() - 1, '1', News::STATUS_ACTIVE, '2.jpg', time(), time(), 1, 1], // 2
                        [time(), '1', News::STATUS_ACTIVE, '3.jpg', time(), time(), 1, 1], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(NewsTranslation::tableName(),
                    [
                        'parent_id', 'locale', 'slug',
                        'title', 'description', 'content',
                        'meta_title', 'meta_keywords', 'meta_description',
                        'image_description', 'redirect'
                    ],
                    [
                        ['1', 'en-US', 'news-1', 'News #1', 'Description #1', 'Content #1', 'Meta Title #1', 'Meta Keywords #1', 'Meta Description #1', 'Image Description #1', ''],
                        ['1', 'ru-RU', 'news-1-ru', 'News #1 Ru', 'Description #1 Ru', 'Content #1 Ru', 'Meta Title #1 Ru', 'Meta Keywords #1 Ru', 'Meta Description #1 Ru', 'Image Description #1 Ru', ''],

                        ['2', 'en-US', 'news-2', 'News #2 (with redirect)', 'Description #2', 'Content #2', 'Meta Title #2', 'Meta Keywords #2', 'Meta Description #2', 'Image Description #2', 'http://www.google.com'],
                        ['2', 'ru-RU', 'news-2-ru', 'News #2 Ru (with redirect)', 'Description #2 Ru', 'Content #2 Ru', 'Meta Title #2 Ru', 'Meta Keywords #2 Ru', 'Meta Description #2 Ru', 'Image Description #2 Ru', 'http://www.google.com'],

                        ['3', 'en-US', 'news-3', 'News #3', 'Description #3', 'Content #3', 'Meta Title #3', 'Meta Keywords #3', 'Meta Description #3', 'Image Description #3', ''],
                        ['3', 'ru-RU', 'news-3-ru', 'News #3 Ru', 'Description #3 Ru', 'Content #3 Ru', 'Meta Title #3 Ru', 'Meta Keywords #3 Ru', 'Meta Description #3 Ru', 'Image Description #3 Ru', ''],
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert('{{%news_news_category}}', ['news_id', 'category_id'],
                    [
                        [1, 1], // 1
                        [1, 2], // 2
                        [1, 3], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert('{{%news_news_tags}}', ['news_id', 'tag_id'],
                    [
                        [1, 1], // 1
                        [2, 2], // 2
                        [3, 3], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(NewsGallery::tableName(), ['parent_id', 'position', 'image'],
                    [
                        [1, '1', '1.jpg'], // 1
                        [1, '2', '2.jpg'], // 2
                        [1, '3', '3.jpg'], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(NewsGalleryTranslation::tableName(), ['parent_id', 'locale', 'image_text'],
                    [
                        ['1', 'en-US', 'Image #1'],
                        ['1', 'ru-RU', 'Image #1 Ru'],

                        ['2', 'en-US', 'Image #2'],
                        ['2', 'ru-RU', 'Image #2 Ru'],

                        ['3', 'en-US', 'Image #3'],
                        ['3', 'ru-RU', 'Image #3 Ru'],
                    ])
                ->execute();

            FileHelper::copyDirectory(Yii::getAlias('@frontend/web/install/uploads/news'), Yii::getAlias('@frontend/web/uploads/news'));
            FileHelper::copyDirectory(Yii::getAlias('@frontend/web/install/uploads/news_gallery'), Yii::getAlias('@frontend/web/uploads/news_gallery'));
        }


        if($data == 'banner' || $data == 'all') {
            /* Banner */
            Yii::$app->db->createCommand()
                ->batchInsert(BannerPlace::tableName(), ['title'],
                    [
                        ['First place'], // 1
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(Banner::tableName(),
                    [
                        'locale', 'place_id', 'title', 'image', 'link', 'new_wnd',
                        'status', 'priority', 'created_at', 'updated_at', 'created_by', 'updated_by'
                    ],
                    [
                        [
                            'en-US', '1', 'First banner', '1.jpg', 'http://www.google.com', '1',
                            Banner::STATUS_ACTIVE, 1, time(), time(), 1, 1
                        ], // 1
                    ])
                ->execute();

            FileHelper::copyDirectory(Yii::getAlias('@frontend/web/install/uploads/banner'), Yii::getAlias('@frontend/web/uploads/banner'));
        }


        if($data == 'vote' || $data == 'all') {
            /* Vote */
            Yii::$app->db->createCommand()
                ->batchInsert(Vote::tableName(), ['status', 'type', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [Vote::STATUS_ACTIVE, Vote::TYPE_SINGLE, time(), time(), 1, 1], // 1
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(VoteTranslation::tableName(), ['parent_id', 'locale', 'title'],
                    [
                        ['1', 'en-US', 'Vote #1'],
                        ['1', 'ru-RU', 'Vote #1 Ru'],
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(VoteOption::tableName(), ['parent_id', 'position'],
                    [
                        [1, 1], // 1
                        [1, 2], // 1
                        [1, 3], // 1
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(VoteOptionTranslation::tableName(), ['parent_id', 'locale', 'title'],
                    [
                        ['1', 'en-US', 'Option #1'],
                        ['1', 'ru-RU', 'Option #1 Ru'],

                        ['2', 'en-US', 'Option #2'],
                        ['2', 'ru-RU', 'Option #2 Ru'],

                        ['3', 'en-US', 'Option #3'],
                        ['3', 'ru-RU', 'Option #3 Ru'],
                    ])
                ->execute();
        }


        if($data == 'menu' || $data == 'all') {
            /* Menu */
            Yii::$app->db->createCommand()
                ->batchInsert(Menu::tableName(), ['status', 'parent_id', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [Menu::STATUS_ACTIVE, null, 1, time(), time(), 1, 1], // 1
                        [Menu::STATUS_ACTIVE, null, 2, time(), time(), 1, 1], // 2
                        [Menu::STATUS_ACTIVE, 1, 1, time(), time(), 1, 1], // 3
                        [Menu::STATUS_ACTIVE, 1, 2, time(), time(), 1, 1], // 4
                        [Menu::STATUS_ACTIVE, 1, 3, time(), time(), 1, 1], // 5
                        [Menu::STATUS_ACTIVE, 5, 1, time(), time(), 1, 1], // 6
                        [Menu::STATUS_ACTIVE, 2, 1, time(), time(), 1, 1], // 7
                        [Menu::STATUS_ACTIVE, 2, 2, time(), time(), 1, 1], // 8
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(MenuTranslation::tableName(), ['parent_id', 'locale', 'title', 'link'],
                    [
                        ['1', 'en-US', 'Main menu', ''],
                        ['1', 'ru-RU', 'Main menu Ru', ''],

                        ['2', 'en-US', 'Bottom menu', ''],
                        ['2', 'ru-RU', 'Bottom menu Ru', ''],

                        ['3', 'en-US', 'Home', '/'],
                        ['3', 'ru-RU', 'Home Ru', '/'],

                        ['4', 'en-US', 'Contact', '/site/contact'],
                        ['4', 'ru-RU', 'Contact Ru', '/site/contact'],

                        ['5', 'en-US', 'News', '/news'],
                        ['5', 'ru-RU', 'News Ru', '/news'],

                        ['6', 'en-US', 'Category 1', '/news/category/cat-1'],
                        ['6', 'ru-RU', 'Category 1 Ru', '/news/category/cat-1'],

                        ['7', 'en-US', 'Contact', '/site/contact'],
                        ['7', 'ru-RU', 'Contact Ru', '/site/contact'],

                        ['8', 'en-US', 'About us', '/page/about'],
                        ['8', 'ru-RU', 'About us Ru', '/page/about'],
                    ])
                ->execute();

        }


        if($data == 'page' || $data == 'all') {
            /* Page */
            Yii::$app->db->createCommand()
                ->batchInsert(Page::tableName(), ['status', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [Page::STATUS_ACTIVE, time(), time(), 1, 1], // 1
                        [Page::STATUS_ACTIVE, time(), time(), 1, 1], // 2
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(PageTranslation::tableName(), ['parent_id', 'locale', 'slug', 'title', 'description', 'content', 'meta_title', 'meta_keywords', 'meta_description'],
                    [
                        ['1', 'en-US', 'main-page', 'Main page text title', 'Main page text description', 'Main page text contents', 'Main page text Meta title', 'Main page text Meta keywords', 'Main page text Meta description'],
                        ['1', 'ru-RU', 'main-page-ru', 'Main page text title Ru', 'Main page text description Ru', 'Main page text contents Ru', 'Main page text Meta title Ru', 'Main page text Meta keywords Ru', 'Main page text Meta description Ru'],

                        ['2', 'en-US', 'about', 'About', 'About description', 'About text', 'About meta title', 'About meta keywords', 'About meta description'],
                        ['2', 'ru-RU', 'about-ru', 'About Ru', 'About description Ru', 'About text Ru', 'About meta title Ru', 'About meta keywords Ru', 'About meta description Ru'],
                    ])
                ->execute();

        }


        if($data == 'slider' || $data == 'all') {
            /* Slider */
            Yii::$app->db->createCommand()
                ->batchInsert(Slider::tableName(), ['title'],
                    [
                        ['Main slider'], // 1
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(Slide::tableName(), ['slider_id', 'image', 'status', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                    [
                        [1, '1.jpg', Slide::STATUS_ACTIVE, 1, time(), time(), 1, 1], // 1
                        [1, '2.jpg', Slide::STATUS_ACTIVE, 2, time(), time(), 1, 1], // 2
                        [1, '3.jpg', Slide::STATUS_ACTIVE, 3, time(), time(), 1, 1], // 3
                    ])
                ->execute();

            Yii::$app->db->createCommand()
                ->batchInsert(SlideTranslation::tableName(), ['parent_id', 'locale', 'title', 'description', 'link'],
                    [
                        ['1', 'en-US', 'Slide #1', 'Text for slide #1', 'http://www.twitter.com'],
                        ['1', 'ru-RU', 'Slide #1 Ru', 'Text for slide #1 Ru', 'http://www.twitter.com'],

                        ['2', 'en-US', 'Slide #2', 'Text for slide #2', 'http://www.facebook.com'],
                        ['2', 'ru-RU', 'Slide #2 Ru', 'Text for slide #2 Ru', 'http://www.facebook.com'],

                        ['3', 'en-US', 'Slide #3', '', ''],
                        ['3', 'ru-RU', 'Slide #3 Ru', '', ''],
                    ])
                ->execute();

            FileHelper::copyDirectory(Yii::getAlias('@frontend/web/install/uploads/slide'), Yii::getAlias('@frontend/web/uploads/slide'));
        }


        echo 'Done!';
        Yii::$app->cache->flush();
    }
}

?>