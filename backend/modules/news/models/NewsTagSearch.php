<?php

namespace backend\modules\news\models;

use common\modules\news\models\NewsTag;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsTagSearch represents the model behind the search form about `common\modules\news\models\NewsTag`.
 */
class NewsTagSearch extends NewsTag
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
        $query = NewsTag::find();

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

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
