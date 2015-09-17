<?php

namespace backend\modules\radiata\models;

use backend\modules\radiata\helpers\RadiataHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\forms\DateRangeValidator;
use backend\forms\helpers\FieldHelper;

/**
 * AdminLogSearch represents the model behind the search form about `backend\modules\radiata\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['created_at'], DateRangeValidator::className()],
            [['module', 'model', 'action', 'data', 'icon'], 'safe'],
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
        $query = AdminLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        list($from, $to) = FieldHelper::getDateFromRange($this->created_at);

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'action'  => $this->action,
        ])
            ->andFilterWhere(['between', 'created_at', $from, $to])
            ->andFilterWhere(['like', 'data', $this->data]);


        return $dataProvider;
    }

    public static function getUsers()
    {
        $usersData = AdminLog::find()
            ->select('user_id')
            ->distinct()
            ->joinWith('user')
            ->orderBy(
                [
                    'last_name'  => SORT_ASC,
                    'first_name' => SORT_ASC,
                ]
            )
            ->all();

        if(count($usersData) > 0) {
            $users = [];
            foreach ($usersData as $userData) {
                $users[$userData['user']->id] = $userData['user']->getFullName();
            }

            return $users;
        } else {
            return [];
        }
    }

    public static function getActions()
    {
        $actionsData = AdminLog::find()
            ->select('action')
            ->distinct()
            ->column();

        if(count($actionsData) > 0) {
            $actions = [];
            foreach ($actionsData as $action) {
                $actions[$action] = RadiataHelper::getActionName($action);
            }

            return $actions;
        } else {
            return [];
        }
    }
}
