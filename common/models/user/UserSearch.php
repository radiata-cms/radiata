<?php

namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\user\User;
use backend\forms\DateRangeValidator;

/**
 * UserSearch represents the model behind the search form about `common\models\user\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], DateRangeValidator::className()],
            [['email'], 'email'],
            [['username', 'first_name', 'last_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        if (preg_match("/([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4}) \\- ([0-9]{2}[\\/|\\.]{1}[0-9]{2}[\\/|\\.]{1}[0-9]{4})/", $this->created_at, $mm)) {
            $from = strtotime($mm[1]);
            $to = strtotime($mm[2]) + 3600 * 24;
        } else {
            $from = null;
            $to = null;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['between', 'created_at', $from, $to]);

        return $dataProvider;
    }
}
