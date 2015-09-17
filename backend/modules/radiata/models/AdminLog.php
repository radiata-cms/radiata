<?php

namespace backend\modules\radiata\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use common\models\user\User;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%radiata_admin_log}}".
 *
 * @property integer $id
 * @property string $action
 * @property integer $user_id
 * @property string $data
 * @property integer $created_at
 *
 * @property User $user
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action'], 'required'],
            [['user_id'], 'integer'],
            [['data'], 'string'],
            [['action'], 'string', 'max' => 32],
            [['icon'], 'string', 'max' => 50],
            [['module'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('b/radiata/admin-log', 'ID'),
            'module' => Yii::t('b/radiata/admin-log', 'Module'),
            'model' => Yii::t('b/radiata/admin-log', 'Model'),
            'action' => Yii::t('b/radiata/admin-log', 'Action'),
            'user_id' => Yii::t('b/radiata/admin-log', 'User ID'),
            'data' => Yii::t('b/radiata/admin-log', 'Data'),
            'created_at' => Yii::t('b/radiata/admin-log', 'Create Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
