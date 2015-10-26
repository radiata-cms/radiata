<?php

namespace common\modules\page\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use common\models\user\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page_page}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property PageTranslation[] $translations
 */
class Page extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_page}}';
    }

    /**
     * @inheritdoc
     * @return \common\modules\page\models\active_query\PageActiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\page\models\active_query\PageActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer']
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
                'titleAttribute' => 'title',
                'icon'           => 'fa-file-o bg-orange',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'slug', 'description', 'content', 'meta_title', 'meta_keywords', 'meta_description'],
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
            'id'               => Yii::t('b/page', 'ID'),
            'status'           => Yii::t('b/page', 'Status'),
            'created_at'       => Yii::t('b/page', 'Created At'),
            'updated_at'       => Yii::t('b/page', 'Updated At'),
            'created_by'       => Yii::t('b/page', 'Created By'),
            'updated_by'       => Yii::t('b/page', 'Updated By'),
            'slug'             => Yii::t('b/page', 'Slug'),
            'title'            => Yii::t('b/page', 'Title'),
            'description'      => Yii::t('b/page', 'Description'),
            'content'          => Yii::t('b/page', 'Content'),
            'meta_title'       => Yii::t('b/page', 'Meta title'),
            'meta_keywords'    => Yii::t('b/page', 'Meta keywords'),
            'meta_description' => Yii::t('b/page', 'Meta description'),
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
        return $this->hasMany(PageTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/news', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/news', 'status' . self::STATUS_DISABLED),
        ];
    }
}
