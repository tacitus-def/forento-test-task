<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Person;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $sex;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sex', 'required'],
            ['sex', 'in', 'range' => [Person::SEX_FEMALE, Person::SEX_MALE]],

            ['name', 'required'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Person();
        $user->name = $this->name;
        $user->sex = $this->sex;
        $user->deleted = Person::NOT_DELETED;
        $user->status_id = Person::STATUS_INACTIVE;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param Person $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
