<?php

namespace common\models;

use Yii;
use common\models\Client;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property boolean $deleted
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $type_is
 * @property Client[] $clients
 */
class User extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const NOT_DELETED = 0;
    const DELETED = 1;
    const TYPE_PERSON = 0;
    const TYPE_GROUP = 1;

    public function getClients() {
        return $this->hasMany(Client::class, ['id' => 'client_id'])
                    ->viaTable('{{%user_client}}', ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
