<?php

namespace common\modules\vote\models;

use Yii;

/**
 * This is the model class for table "{{%vote_log}}".
 *
 * @property integer $option_id
 * @property integer $vote_id
 * @property string $date
 * @property string $ip
 *
 * @property VoteOption $option
 */
class VoteLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'date', 'ip'], 'required'],
            [['option_id', 'vote_id', 'ip', 'date'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('b/vote/log', 'Option ID'),
            'vote_id'   => Yii::t('b/vote/log', 'Vote ID'),
            'date'      => Yii::t('b/vote/log', 'Date'),
            'ip'        => Yii::t('b/vote/log', 'Ip'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(VoteOption::className(), ['id' => 'option_id']);
    }

    /**
     * @return void
     */
    public function addAnswer($voteId, $optionId)
    {
        $this->vote_id = $voteId;
        $this->option_id = $optionId;
        $this->ip = ip2long(Yii::$app->request->getUserIP());
        $this->date = time();
        $this->save();
    }
}
