<?php

namespace backend\modules\radiata\models;

use common\modules\radiata\models\TextBlock;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TextBlockSearch represents the model behind the search form about `common\modules\radiata\models\TextBlock`.
 */
class TextBlockSearch extends TextBlock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'key', 'text'], 'safe'],
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
        $query = TextBlock::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
