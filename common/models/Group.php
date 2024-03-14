<?php

namespace common\models;

/**
 * Group model
 *
 * @property integer $id
 * @property string $name
 * @property boolean $deleted
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property Client[] $clients
 * @property Person[] $persons
 * @property string $password write-only password
 */
class Group extends User {

    public function getPersons() {
        return $this->hasMany(Person::class, ['id' => 'person_id'])
                    ->viaTable('{{%group_person}}', ['group_id' => 'id']);
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
            'type_is' => self::TYPE_GROUP,
                ];
        return static::findOne($condition);
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->type_is = self::TYPE_GROUP;
        }
        return parent::beforeSave($insert);
    }
}
