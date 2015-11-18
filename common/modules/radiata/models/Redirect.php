<?php

namespace common\modules\radiata\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use common\models\user\User;
use common\modules\radiata\helpers\CacheHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%radiata_redirect}}".
 *
 * @property integer $id
 * @property string $old_urt
 * @property string $new_url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 */
class Redirect extends \yii\db\ActiveRecord
{
    public static function processRedirect()
    {
        $redirects = CacheHelper::get('redirects');
        if(empty($redirects)) {
            $redirects = (new Query())->select(['old_url', 'new_url'])->from(Redirect::tableName())->all();
            $redirects = ArrayHelper::map($redirects, 'old_url', 'new_url');
            CacheHelper::set('redirects', $redirects, CacheHelper::getTag(self::className()));
        }

        $url = $_SERVER['REQUEST_URI'];
        if(isset($redirects[$url])) {
            Yii::$app->response->redirect($redirects[$url], 301);
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_redirect}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_url', 'new_url'], 'required'],
            [['old_url', 'new_url'], 'string', 'max' => 255],
            [['old_url'], 'unique']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            CacheBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'old_url',
                'icon'           => 'fa-exchange bg-redirect',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_url' => Yii::t('b/radiata/redirect', 'Old URL'),
            'new_url' => Yii::t('b/radiata/redirect', 'New URL'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
