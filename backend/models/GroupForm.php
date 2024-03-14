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
        ];
    }

    public function getModel() {
        return $this->_model;
    }

    public function setModel(Group $model)
    {
        $this->name = $model->name;
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
        $group->status_id = $this->status;

        if ($group->isNewRecord) {
            $group->deleted = Group::NOT_DELETED;
        }

        return $group->save();
    }
}
