<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Group;

/**
 * Description of UserForm
 *
 * @author demiurg
 */
class GroupForm extends Model {
    /** @var Group */
    protected $_model;
    public $name;
    public $status;
    public $email;
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
            [['model'], fn($attr) => $this->$attr instanceof Group],
            ['status', 'required'],
            ['status', 'in', 'range' => [Group::STATUS_INACTIVE, Group::STATUS_ACTIVE]],

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

    public function setModel(Group $model)
    {
        $this->name = $model->name;
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

        $group = $this->model;
        $group->name = $this->name;
        $group->email = $this->email;
        $group->status_id = $this->status;

        if ($this->password) {
            $group->setPassword($this->password);
            $group->generateAuthKey();
        }
        if ($group->isNewRecord) {
            $group->deleted = Group::NOT_DELETED;
        }

        return $group->save();
    }
}
