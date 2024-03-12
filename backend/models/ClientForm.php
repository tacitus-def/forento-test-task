<?php

namespace backend\models;

use Yii;
use common\models\Client;
use yii\base\Model;

/**
 * Description of ClientForm
 *
 * @author demiurg
 */
class ClientForm extends Model {
    public $name;
    public $description;
    public $account_type;
    public $balance;
    public $status;

    /** @var Client */
    protected $_model;

    public function sameName($model) {
        return ($model->name != $this->_model->name);
    }

    public function rules() {
        return [
            [['model'], 'required'],
            [['model'], fn($attr) => $this->$attr instanceof Client],
            ['description', 'safe'],
            ['balance', 'default', 'value' => 0],
            ['balance', 'double'],
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique',
                'targetClass' => '\common\models\Client',
                'message' => 'This name has already been taken.',
                'when' => [$this, 'sameName'],
                    ],
            ['account_type', 'required'],
            ['account_type', 'in', 'range' => [Client::TYPE_PRIVATE, Client::TYPE_LIMITED, Client::TYPE_PUBLIC]],
            ['status', 'required'],
            ['status', 'in', 'range' => [Client::STATUS_INACTIVE, Client::STATUS_ACTIVE]],
        ];
    }

    public function getModel() {
        return $this->_model;
    }

    public function setModel(Client $model) {
        $this->_model = $model;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->account_type = $model->account_type;
        $this->balance = $model->balance;
        $this->status = $model->status;
    }

    public function save() {
        if (!$this->validate()) {
            return null;
        }

        $model = $this->_model;

        $model->name = $this->name;
        $model->description = $this->description;
        $model->account_type = $this->account_type;
        $model->balance = $this->balance;
        $model->status = $this->status;
        if ($model->isNewRecord) {
            $model->created_by = Yii::$app->user->getId();
        }
        else {
            $model->updated_by = Yii::$app->user->getId();
        }

        return $model->save();
    }
}
