<?php

namespace common\models;

use Yii;
use common\models\Person;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $account_type
 * @property float $balance
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property int $deleted
 * @property Person[] $users
 */
class Client extends \yii\db\ActiveRecord
{
    const TYPE_PRIVATE = 0;
    const TYPE_PUBLIC = 1;
    const TYPE_LIMITED = 2;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    public function attributeLabels() {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'account_type' => 'Type',
            'balance' => 'Balance',
            'status' => 'Status',
        ];
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

    public function getUsers() {
        return $this->hasMany(Person::class, ['id' => 'user_id'])
                    ->viaTable('{{%user_client}}', ['client_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['account_type', 'default', 'value' => self::TYPE_PUBLIC],
            ['account_type', 'in', 'range' => [self::TYPE_PRIVATE, self::TYPE_PUBLIC, self::TYPE_LIMITED]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::TYPE_PRIVATE, self::STATUS_ACTIVE]],
            ['deleted', 'default', 'value' => self::NOT_DELETED],
            ['deleted', 'in', 'range' => [self::NOT_DELETED, self::DELETED]],
            ['balance', 'default', 'value' => 0],
            ['balance', 'double'],
        ];
    }
}
