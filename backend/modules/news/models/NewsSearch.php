<?php

namespace backend\modules\news\models;

use backend\forms\DateRangeValidator;
use backend\forms\helpers\FieldHelper;
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
            [['id', 'category_id', 'status'], 'integer'],
            [['title'], 'string'],
            [['date'], DateRangeValidator::className()],
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
        $query = News::find();

        $query->language();

        $query->order();

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
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status'      => $this->status,
        ]);

        list($from, $to) = FieldHelper::getDateFromRange($this->date);
        $query->andFilterWhere(['between', 'date', $from, $to]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
