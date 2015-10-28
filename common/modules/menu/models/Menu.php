<?php

namespace common\modules\menu\models;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\CacheBehavior;
use backend\modules\radiata\behaviors\PositionBehavior;
use backend\modules\radiata\behaviors\TranslateableBehavior;
use backend\modules\radiata\behaviors\TreeBehavior;
use common\models\user\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%menu_menu}}".
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
 * @property Menu $parent
 * @property Menu[] $menus
 * @property MenuTranslation[] $translations
 */
class Menu extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_menu}}';
    }

    /**
     * @inheritdoc
     * @return \common\modules\menu\models\active_query\MenuActiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\menu\models\active_query\MenuActiveQuery(get_called_class());
    }

    static function getMenu($parent = '')
    {
        return Menu::getSubMenu($parent);
    }

    static function getSubMenu($parent = '')
    {
        $menuItems = [];
        $menu = new Menu;
        $menuStructure = $menu->getStructure();
        $children = $menuStructure[$parent]['children'];

        if(!empty($children)) {
            foreach ($children as $child) {
                $item = $menuStructure[$child];
                $menuItem = [
                    'label' => $item['title'],
                    'url'   => [$item['data']->link]
                ];
                if(!empty($menuStructure[$child]['children'])) {
                    $menuItem['items'] = Menu::getSubMenu($child);
                }
                $menuItems[] = $menuItem;
            }
        }

        return $menuItems;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            ['status', 'in', 'range' => array_keys($this->getStatusesList())],
            [['parent_id', 'position', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer']
        ];
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('b/menu', 'status' . self::STATUS_ACTIVE),
            self::STATUS_DISABLED => Yii::t('b/menu', 'status' . self::STATUS_DISABLED),
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
                'icon'           => 'fa-map-signs bg-dark-olive-green',
            ],
            [
                'class'                        => TranslateableBehavior::className(),
                'translationAttributes'        => ['title', 'link'],
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
            'id'         => Yii::t('b/menu', 'ID'),
            'status'     => Yii::t('b/menu', 'Status'),
            'parent_id'  => Yii::t('b/menu', 'Parent ID'),
            'position'   => Yii::t('b/menu', 'Position'),
            'title'      => Yii::t('b/menu', 'Title'),
            'link'       => Yii::t('b/menu', 'Link'),
            'created_at' => Yii::t('b/menu', 'Created At'),
            'updated_at' => Yii::t('b/menu', 'Updated At'),
            'created_by' => Yii::t('b/menu', 'Created By'),
            'updated_by' => Yii::t('b/menu', 'Updated By'),
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
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(MenuTranslation::className(), ['parent_id' => 'id']);
    }
}
