<?php
namespace common\models\user;

use backend\modules\radiata\behaviors\AdminLogBehavior;
use backend\modules\radiata\behaviors\ImageUploadBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @var string
     */
    public $new_password = '';

    /**
     * @var string
     */
    public $new_password_again = '';

    /**
     * @var string[]
     */
    public $roles = [];

    /**
     * @var string[]
     */
    public $permissions = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%radiata_user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::makeUser(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by params and adds permissions
     *
     * @param array
     * @return User
     */
    public static function makeUser($params)
    {
        $user = static::findOne($params);

        if($user) {
            $user->roles = Yii::$app->authManager->getRolesByUser($user->id);
            $user->permissions = Yii::$app->authManager->getPermissionsByUser($user->id);
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return User
     */
    public static function findByEmail($email)
    {
        return static::makeUser(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by id
     *
     * @param string $email
     * @return User
     */
    public static function findById($id)
    {
        return static::makeUser(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if(!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::makeUser([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if(empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'          => AdminLogBehavior::className(),
                'titleAttribute' => 'email',
                'icon'           => 'fa-user bg-blue',
            ],
            [
                'class'        => ImageUploadBehavior::className(),
                'attribute'    => 'image',
                'defaultImage' => '/images/avatar.jpg',
                'thumbs'       => [
                    'avatar' => ['width' => 100, 'height' => 100],
                ],
                'filePath'     => '@frontend/web/uploads/users/[[pk]]/[[pk]].[[extension]]',
                'fileUrl'      => '/uploads/users/[[pk]]/[[pk]].[[extension]]',
                'thumbPath'    => '@frontend/web/uploads/users/[[pk]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl'     => '/uploads/users/[[pk]]/[[profile]]_[[pk]].[[extension]]',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesList())],

            [['username', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['username', 'first_name', 'last_name'], 'required'],
            [['username', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [['username', 'email'], 'unique'],

            ['new_password', 'required', 'on' => [self::SCENARIO_CREATE]],
            ['new_password_again', 'required', 'on' => [self::SCENARIO_CREATE]],
            ['new_password_again', 'compare', 'compareAttribute' => 'new_password', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['new_password', 'new_password_again'], 'string', 'min' => 6],

            ['roles', 'default', 'value' => ['user']],
            ['roles', function ($attribute, $params) {
                if(is_array($this->$attribute)) {
                    $roles = Yii::$app->authManager->getRoles();
                    foreach ($this->$attribute as $value) {
                        if(!isset($roles[$value])) {
                            $this->addError('Invalide role');
                        }
                    }
                }
            }
            ],
            ['permissions', function ($attribute, $params) {
                if(is_array($this->$attribute)) {
                    $roles = Yii::$app->authManager->getPermissions();
                    foreach ($this->$attribute as $value) {
                        if(!isset($roles[$value])) {
                            $this->addError('Invalide permission');
                        }
                    }
                }
            }
            ],
        ];
    }

    /**
     * Get statuses list
     */
    public function getStatusesList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('b/radiata/user', 'status' . self::STATUS_DISABLED),
            self::STATUS_ACTIVE   => Yii::t('b/radiata/user', 'status' . self::STATUS_ACTIVE),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('b/radiata/user', 'ID'),
            'username'             => Yii::t('b/radiata/user', 'Username'),
            'first_name'           => Yii::t('b/radiata/user', 'First name'),
            'last_name'            => Yii::t('b/radiata/user', 'Last name'),
            'auth_key'             => Yii::t('b/radiata/user', 'Auth key'),
            'password_hash'        => Yii::t('b/radiata/user', 'Passsword hash'),
            'password_reset_token' => Yii::t('b/radiata/user', 'Passsword reset hash'),
            'new_password'         => Yii::t('b/radiata/user', 'New password'),
            'new_password_again'   => Yii::t('b/radiata/user', 'New password again'),
            'email'                => Yii::t('b/radiata/user', 'Email'),
            'status'               => Yii::t('b/radiata/user', 'Status'),
            'updated_at'           => Yii::t('b/radiata/user', 'Update Date'),
            'created_at'           => Yii::t('b/radiata/user', 'Create Date'),
            'image'                => Yii::t('b/radiata/user', 'Avatar'),
            'roles'                => Yii::t('b/radiata/user', 'Roles'),
            'permissions'          => Yii::t('b/radiata/user', 'Permissions'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Save user RBAC
     */
    public function saveUserRbac()
    {
        Yii::$app->authManager->revokeAll($this->id);

        if(is_array(Yii::$app->request->post('User')['roles'])) {
            foreach (Yii::$app->request->post('User')['roles'] as $role) {
                $rbacRole = Yii::$app->authManager->getRole($role);
                Yii::$app->authManager->assign($rbacRole, $this->id);
            }
        } else {
            $rbacRole = Yii::$app->authManager->getRole('user');
            Yii::$app->authManager->assign($rbacRole, $this->id);
        }

        if(
            is_array(Yii::$app->request->post('User')['roles'])
            &&
            in_array('manager', Yii::$app->request->post('User')['roles'])
            &&
            is_array(Yii::$app->request->post('User')['permissions'])
        ) {
            foreach (Yii::$app->request->post('User')['permissions'] as $permission) {
                $rbacPermission = Yii::$app->authManager->getPermission($permission);
                Yii::$app->authManager->assign($rbacPermission, $this->id);
            }
        }

        Yii::$app->authManager->invalidateCache();
    }

    /**
     * Get user full name
     */
    public function getFullName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
