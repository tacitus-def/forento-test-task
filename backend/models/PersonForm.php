<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Person;

/**
 * Description of UserForm
 *
 * @author demiurg
 */
class PersonForm extends Model {
    /** @var Person */
    protected $_model;
    public $name;
    public $email;
    public $sex;
    public $status;
    public $password;

    public function sameEmail($model) {
        return ($model->email != $this->_model->email);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'required'],
            [['model'], fn($attr) => $this->$attr instanceof Person],
            ['sex', 'required'],
            ['sex', 'in', 'range' => [Person::SEX_FEMALE, Person::SEX_MALE]],
            ['status', 'required'],
            ['status', 'in', 'range' => [Person::STATUS_INACTIVE, Person::STATUS_ACTIVE]],

            ['name', 'required'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.',
                'when' => [$this, 'sameEmail']
                    ],

            ['password', 'required', 
                'when' => fn($form) => $form->model->isNewRecord,
                'whenClient' => 'function (attr, value) { '
                    .'return '.($this->model->isNewRecord ? 'true' : 'false').';'
                    .' }',
                        ],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function getModel() {
        return $this->_model;
    }

    public function setModel(Person $model)
    {
        $this->name = $model->name;
        $this->sex = $model->sex;
        $this->email = $model->email;
        $this->status = $model->status_id;

        $this->_model = $model;
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = $this->model;
        $user->name = $this->name;
        $user->sex = $this->sex;
        $user->email = $this->email;
        $user->status_id = $this->status;
        if ($this->password) {
            Yii::debug('UserForm::save(): set password');
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }

        if ($user->isNewRecord) {
            $user->deleted = Person::NOT_DELETED;
        }

        return $user->save();
    }
}
