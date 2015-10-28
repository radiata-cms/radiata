<?php

namespace backend\modules\slider\models;

use common\modules\slider\models\Slide;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SlideSearch represents the model behind the search form about `common\modules\slider\models\Slide`.
 */
class SlideSearch extends Slide
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'slider_id', 'status'], 'integer'],
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
        $query = Slide::find();

        $query->language();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->slider_id) {
            $query->orderBy(['position' => SORT_ASC]);
        } else {
            $query->orderBy(['title' => SORT_ASC]);
        }

        $query->andFilterWhere([
            'slider_id' => $this->slider_id,
            'status'    => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
