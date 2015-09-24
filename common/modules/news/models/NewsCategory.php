<?php

namespace common\modules\news\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\PositionBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use backend\modules\radiata\behaviors\TreeBehavior;
use common\models\user\User;
use common\modules\news\models\active_query\NewsCategoryActiveQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $parent_id
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property NewsCategory $parent
 * @property NewsCategoryTranslation[] $translations
 * @property NewsCategory[] $children
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['parent_id'], 'default', 'value' => null],
            [['status', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            ['position', 'unique', 'targetAttribute' => ['parent_id', 'position']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('b/news/category', 'ID'),
            'status'           => Yii::t('b/news/category', 'Status'),
            'parent_id'        => Yii::t('b/news/category', 'Parent'),
            'position'         => Yii::t('b/news/category', 'Position'),

            'slug'             => Yii::t('b/news/category', 'Slug'),
            'title'            => Yii::t('b/news/category', 'Title'),
            'meta_title'       => Yii::t('b/news/category', 'Meta title'),
            'meta_keywords'    => Yii::t('b/news/category', 'Meta keywords'),
            'meta_description' => Yii::t('b/news/category', 'Meta description'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            PositionBehavior::className(),
            CacheBehavior::className(),
            TreeBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'title',
                'icon'           => 'fa-cubes bg-lime',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'slug', 'body', 'meta_title', 'meta_keywords', 'meta_description'],
                'translationLanguageAttribute' => 'locale',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
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
    public function getParent()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsCategoryTranslation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(NewsCategory::className(), ['parent_id' => 'id']);
    }

    public static function find()
    {
        return new NewsCategoryActiveQuery(get_called_class());
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/news/category', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/news/category', 'status' . self::STATUS_DISABLED),
        ];
    }
}
