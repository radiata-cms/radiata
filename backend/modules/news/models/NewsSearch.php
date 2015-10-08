<?php

namespace backend\modules\news\models;

use common\modules\news\models\News;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `common\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'category_id', 'status'], 'integer'],
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
        $query = News::find();

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
            'date'        => $this->date,
            'category_id' => $this->category_id,
            'status'      => $this->status,
        ]);

        /*
        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'image_description', $this->image_description])
            ->andFilterWhere(['like', 'redirect', $this->redirect]);
        */

        return $dataProvider;
    }
}
