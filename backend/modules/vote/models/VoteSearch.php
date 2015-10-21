<?php

namespace backend\modules\vote\models;

use common\modules\vote\models\Vote;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VoteSearch represents the model behind the search form about `common\modules\vote\models\Vote`.
 */
class VoteSearch extends Vote
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['title'], 'string'],
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
        $query = Vote::find();

        $query->language();

        $query->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere('title', 'like', $this->title);

        return $dataProvider;
    }
}
