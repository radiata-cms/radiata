<?php

namespace common\modules\news\models;

use common\models\user\User;
use Yii;

/**
 * This is the model class for table "{{%news_news}}".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $category_id
 * @property integer $status
 * @property string $image
 * @property string $image_description
 * @property string $redirect
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property NewsCategory $category
 * @property User $createdBy
 * @property User $updatedBy
 * @property NewsCategory[] $categories
 * @property NewsTranslation[] $translations
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'category_id', 'status'], 'required'],
            [['date', 'category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image', 'image_description', 'redirect'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('b/news/news', 'ID'),
            'date'              => Yii::t('b/news/news', 'Date'),
            'category_id'       => Yii::t('b/news/news', 'Category ID'),
            'status'            => Yii::t('b/news/news', 'Status'),
            'image'             => Yii::t('b/news/news', 'Image'),
            'image_description' => Yii::t('b/news/news', 'Image Description'),
            'redirect'          => Yii::t('b/news/news', 'Redirect'),
            'created_at'        => Yii::t('b/news/news', 'Created At'),
            'updated_at'        => Yii::t('b/news/news', 'Updated At'),
            'created_by'        => Yii::t('b/news/news', 'Created By'),
            'updated_by'        => Yii::t('b/news/news', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(NewsCategory::className(), ['id' => 'category_id'])->viaTable('{{%news_news_category}}', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsTranslation::className(), ['parent_id' => 'id']);
    }
}
