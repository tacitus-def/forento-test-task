<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * Person model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $name
 * @property boolean $sex
 * @property boolean $deleted
 * @property string $auth_key
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Client[] $clients
 * @property Group[] $groups
 */
class Person extends User implements IdentityInterface {
    const SEX_FEMALE = 0;
    const SEX_MALE = 1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status_id', 'default', 'value' => self::STATUS_ACTIVE],
            ['status_id', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['deleted', 'default', 'value' => self::NOT_DELETED],
            ['deleted', 'in', 'range' => [self::NOT_DELETED, self::DELETED]],
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->type_is = self::TYPE_PERSON;
        }
        return parent::beforeSave($insert);
    }
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email,
            'status_id' => self::STATUS_ACTIVE,
            'deleted' => self::NOT_DELETED,
            'type_is' => self::TYPE_PERSON,
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status_id' => self::STATUS_ACTIVE,
            'deleted' => self::NOT_DELETED,
            'type_is' => self::TYPE_PERSON,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status_id' => self::STATUS_INACTIVE,
            'deleted' => self::NOT_DELETED,
            'type_is' => self::TYPE_PERSON,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
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
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'deleted' => self::NOT_DELETED,
            'status_id' => self::STATUS_ACTIVE,
            'type_is' => self::TYPE_PERSON
                ]);
    }
}
