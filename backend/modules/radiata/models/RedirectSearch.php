<?php

namespace backend\modules\radiata\models;

use common\modules\radiata\models\Redirect;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RedirectSearch represents the model behind the search form about `common\modules\radiata\models\Redirect`.
 */
class RedirectSearch extends Redirect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_url', 'new_url'], 'safe'],
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
     * @inheritdoc
     */
    public function afterValidate()
    {
        // skip
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
        $query = Redirect::find();

        $query->orderBy(['old_url' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'old_url', $this->old_url])
            ->andFilterWhere(['like', 'new_url', $this->new_url]);

        return $dataProvider;
    }
}
