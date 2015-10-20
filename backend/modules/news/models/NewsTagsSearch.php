<?php

namespace backend\modules\news\models;

use common\modules\news\models\NewsTags;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsTagsSearch represents the model behind the search form about `common\modules\news\models\NewsTags`.
 */
class NewsTagsSearch extends NewsTags
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NewsTags::find();

        $query->language();

        $query->orderBy(['name' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['translations' => function ($q) {
            $q->where('name LIKE "%' . $this->name . '%"');
        }]);

        return $dataProvider;
    }
}
