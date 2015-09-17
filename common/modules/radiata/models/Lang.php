<?php

namespace common\modules\radiata\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\ClearCacheBehavior;
use common\modules\radiata\helpers\CacheHelper;
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'locale', 'name'], 'required'],
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
            'id' => Yii::t('c/radiata/lang', 'ID'),
            'code' => Yii::t('c/radiata/lang', 'Language slug'),
            'locale' => Yii::t('c/radiata/lang', 'Locale'),
            'name' => Yii::t('c/radiata/lang', 'Name'),
            'default' => Yii::t('c/radiata/lang', 'Default'),
            'position' => Yii::t('c/radiata/lang', 'Position'),
            'updated_at' => Yii::t('c/radiata/lang', 'Update Date'),
            'created_at' => Yii::t('c/radiata/lang', 'Create Date'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => AdminLogBehavior::className(),
                'titleAttribute' => 'name',
                'icon' => 'fa-language bg-teal',
            ],
            ClearCacheBehavior::className(),

            /**
             * @todo-me add behavior for position
             */
        ];
    }

    /**
     * @inheritdoc
     * @return LangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LangQuery(get_called_class());
    }

    /**
     *
     */
    static public function getLanguages()
    {
        $languages = CacheHelper::get('languages');
        if (!$languages) {
            $languages = self::find()->orderBy(['`position`' => SORT_ASC])->all();
            CacheHelper::set('languages', $languages, self::tableName());
        }
        return $languages;
    }


    /**
     *
     */
    public function getLink()
    {
        $link = '';
        if (strpos(Yii::$app->request->getOriginalUrl(), $_SERVER['SCRIPT_NAME']) !== false) {
            $link .= $_SERVER['SCRIPT_NAME'];
        }
        $link .= '/';

        if ($this->code != Yii::$app->getModule('radiata')->defaultLanguage->code)
            $link .= $this->code;

        return $link;
    }


}
