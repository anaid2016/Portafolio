<?php
 
//namespace app\models;
namespace app\api\modules\v1\models;
 
//class User extends \yii\base\Object implements \yii\web\IdentityInterface
class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
 
    private static $users = [
//        '301' => [
//            'id'          => '301',
//            'username'    => 'python',
//            'password'    => 'python',
//            'authKey'     => 'test301key',
//            'accessToken' => '301-token',
//        ],
        '301' => [
            'id'          => '101',
            'username'    => 'python',
            'password'    => 'python',
            'authKey'     => 'python101key',
            //'accessToken' => '101-token',
            // For more security, use a token with a GUID. 
            // Generate GUID: C:\> php -r "echo com_create_guid();"
            'accessToken' => 'WMSAS00498-984B-5BCC-123C-AC22B47E4CD4-token',  
        ],
    ];
 
 
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
 
        return null;
 
        //return static::findOne(['access_token' => $token]);  // when using a database
    }
 
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
 
        return null;
    }
 
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
 
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }
 
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
 
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}