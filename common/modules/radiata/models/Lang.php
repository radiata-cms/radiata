<?php

namespace common\modules\radiata\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use common\modules\radiata\helpers\CacheHelper;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%radiata_lang}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     *
     */
    static public function getLanguages()
    {
        $languages = CacheHelper::get('languages');
        if(!$languages) {
            $languages = self::find()->orderBy(['position' => SORT_ASC])->all();
            CacheHelper::set('languages', $languages, CacheHelper::getTag(self::className()));
        }

        return $languages;
    }

    static function getLangForDropDown()
    {
        $langsAll = self::find()->orderBy(['position' => SORT_ASC])->all();
        $langs = [];

        foreach ($langsAll as $lang) {
            $langs[$lang->locale] = $lang->name;
        }

        return $langs;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'locale', 'name'], 'required'],
            [['code'], 'unique'],
            [['default', 'position', 'updated_at', 'created_at'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['locale'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('b/radiata/lang', 'ID'),
            'code'       => Yii::t('b/radiata/lang', 'Language slug'),
            'locale'     => Yii::t('b/radiata/lang', 'Locale'),
            'name'       => Yii::t('b/radiata/lang', 'Name'),
            'default'    => Yii::t('b/radiata/lang', 'Default'),
            'position'   => Yii::t('b/radiata/lang', 'Position'),
            'updated_at' => Yii::t('b/radiata/lang', 'Update Date'),
            'created_at' => Yii::t('b/radiata/lang', 'Create Date'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => AdminLogBehavior::className(),
                'titleAttribute' => 'name',
                'icon'  => 'fa-language bg-teal',
            ],
            CacheBehavior::className(),
            [
                'class'             => SortableGridBehavior::className(),
                'sortableAttribute' => 'position'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($this->default) {
            $this->setLanguageDefault();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     */
    public function setLanguageDefault()
    {
        Yii::$app->db->createCommand()->update(self::tableName(), ['default' => 0])->execute();
        Yii::$app->db->createCommand()->update(self::tableName(), ['default' => 1], 'id = :id')->bindValue(':id', $this->id)->execute();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_lang}}';
    }

    /**
     *
     */
    public function getLink()
    {
        $link = '';
        if(strpos(Yii::$app->request->getOriginalUrl(), $_SERVER['SCRIPT_NAME']) !== false) {
            $link .= $_SERVER['SCRIPT_NAME'];
        }
        $link .= '/';

        if($this->code != Yii::$app->getModule('radiata')->defaultLanguage->code) {
            $link .= $this->code;
        }

        return $link;
    }
}
