<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;

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
class Person extends User {
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

    public function getGroups() {
        return $this->hasMany(Group::class, ['id' => 'group_id'])
                    ->viaTable('{{%group_person}}', ['person_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $condition = [
            'id' => $id,
            'deleted' => self::NOT_DELETED,
            'status_id' => self::STATUS_ACTIVE,
            'type_is' => self::TYPE_PERSON,
                ];
        return static::findOne($condition);
    }
}
