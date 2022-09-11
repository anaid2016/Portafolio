<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "sge_usuarios".
 *
 * @property int $usuario_id
 * @property string|null $nombre_usuario
 * @property string $correo_electronico Correo de usuario
 * @property string $serwmpskey password
 * @property string|null $setwmpskey_hash password hash
 * @property string|null $setauthkey auth_key
 * @property string|null $setps_reset_token password reset token
 * @property int|null $perfil_id
 * @property string|null $hab_us_token_forzada '1'->habilitado token forzada, '2'->inhabilitado token forzada
 * @property int|null $estado_id 1 habilitado, 2 deshabilitado
 *
 * @property SgePerfiles $perfil
 */
class SgeSureusuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $set_newpassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_sureusuarios';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serwmpskey'], 'required'],
            [['estado_id'], 'default', 'value' => null],
            [['estado_id'], 'integer'],
            [['nombre_usuario'], 'string', 'max' => 120],
            [['correo_electronico', 'serwmpskey', 'setwmpskey_hash', 'setauthkey', 'setps_reset_token'], 'string', 'max' => 255],
            [['hab_us_token_forzada'], 'string', 'max' => 1],
            [['correo_electronico'], 'unique'],
            [['medidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeMedidores::className(), 'targetAttribute' => ['medidor_id' => 'medidor_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ',
            'nombre_usuario' => 'Nombre Usuario',
            'correo_electronico' => 'Correo Electronico',
            'serwmpskey' => 'Contraseña',
            'setwmpskey_hash' => 'Setwmpskey Hash',
            'setauthkey' => 'Setauthkey',
            'setps_reset_token' => 'Setps Reset Token',
            'hab_us_token_forzada' => 'Hab Us Token Forzada',
            'estado_id' => 'Estado ',
            'medidor_id' => 'Medidor',
        ];
    }

    public function getMedidor()
    {
        return $this->hasOne(SgeMedidores::className(), ['medidor_id' => 'medidor_id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */


    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /* removed
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
*/
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($correo)
    {
        return static::findOne(['correo_electronico' => $correo]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
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
    public function getAuthKey()
    {
        return $this->setauthkey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $resultado = password_verify($password, $this->serwmpskey);
        // Yii::warning($password."::".$this->serwmpskey."::".$resultado);
        return $resultado;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->serwmpskey = \yii\base\Security::generatePasswordHash($password, 13);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->setauthkey = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->setps_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->setps_reset_token = null;
    }
    /** EXTENSION MOVIE **/


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            Yii::warning("que es esto");
            if ($this->set_newpassword === true) {
                $this->setauthkey = \Yii::$app->security->generateRandomString();
                $this->setPassword($this->serwmpskey);
            }
            return true;
        }

        return false;
    }
}
