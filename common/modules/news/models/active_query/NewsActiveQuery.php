<?php
namespace common\modules\news\models\active_query;

use common\modules\news\models\News;
use common\modules\news\models\NewsCategory;
use creocoder\taggable\TaggableQueryBehavior;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;

class NewsActiveQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }

    public function language($locale = '')
    {
        if(!$locale) {
            $locale = Yii::$app->language;
        }

        return $this->innerJoinWith(['translations'])->andWhere(['locale' => $locale]);
    }

    public function active()
    {
        $this->andWhere([News::tableName() . '.status' => News::STATUS_ACTIVE]);

        return $this;
    }

    public function order()
    {
        $this->orderBy(['date' => SORT_DESC]);

        return $this;
    }

    public function category($category)
    {
        if(!($category instanceof NewsCategory)) {
            throw new Exception('News category error');
        }

        $children = array_merge([$category->id], $category->getChildrenData());

        $this->joinWith(['categories']);
        $this->andWhere([
            'or',
            ['in', News::tableName() . '.category_id', $children],
            ['in', '{{%news_news_category}}.category_id', $children]
        ]);

        return $this;
    }

    public function tag($tag)
    {
        return $this->joinWith(['tags'])->andWhere(['tag_id' => $tag->id]);
    }
}