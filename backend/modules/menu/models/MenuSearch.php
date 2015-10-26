<?php

namespace backend\modules\menu\models;

use common\modules\menu\models\Menu;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MenuSearch represents the model behind the search form about `common\modules\menu\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'parent_id'], 'integer'],
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
        $query = Menu::find();

        $query->language();

        $query->orderBy(['position' => SORT_DESC]);

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
            'status'                         => $this->status,
            Menu::tableName() . '.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['title', 'like', $this->title]);

        return $dataProvider;
    }
}
