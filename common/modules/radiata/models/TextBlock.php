<?php

namespace common\modules\radiata\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\models\user\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%radiata_textblock}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property TextBlockTranslation[] $radiataTextBlockTranslations
 * @property Lang[] $locales
 */
class TextBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_textblock}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'key'], 'string', 'max' => 255],
            [['name', 'key'], 'unique', 'targetAttribute' => ['name', 'key'], 'message' => Yii::t('b/radiata/textblock', 'The combination of Name and Key has already been taken.')]
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
                'titleAttribute' => 'name',
                'icon'           => 'fa-text-height bg-light-blue',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['text'],
                'translationLanguageAttribute' => 'locale',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            'create' => self::OP_INSERT,
            'update' => self::OP_UPDATE,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('b/radiata/textblock', 'Name'),
            'key'  => Yii::t('b/radiata/textblock', 'Key'),
            'text' => Yii::t('b/radiata/textblock', 'Text'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(TextBlockTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\modules\radiata\models\active_query\TextblockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\radiata\models\active_query\TextblockQuery(get_called_class());
    }
}
