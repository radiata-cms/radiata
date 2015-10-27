<?php

namespace backend\modules\banner\models;

use common\modules\banner\models\Banner;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BannerSearch represents the model behind the search form about `common\modules\banner\models\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'place_id', 'status'], 'integer'],
            [['date_start', 'date_end'], 'date', 'format' => Yii::t('c/radiata/settings', 'dateFormat')],
            [['locale', 'title'], 'safe'],
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
        $query = Banner::find();

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
            'place_id' => $this->place_id,
            'status'   => $this->status,
            'locale'   => $this->locale,
        ]);

        $query->andFilterWhere(['>=', 'date_start', $this->date_start ? strtotime($this->date_start) : '']);
        $query->andFilterWhere(['<=', 'date_end', $this->date_end ? strtotime($this->date_end) : '']);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
