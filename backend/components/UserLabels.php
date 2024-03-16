<?php

namespace backend\components;

use common\models\Person;
use common\models\User;

/**
 * Description of UserMessages
 *
 * @author demiurg
 */
class UserLabels {
    public static function getSexList() {
        return [
            Person::SEX_FEMALE => 'Female',
            Person::SEX_MALE => 'Male',
        ];
    }

    public static function getTypeList() {
        return [
            User::TYPE_PERSON => 'Person',
            User::TYPE_GROUP => 'Group',
        ];
    }

    public static function getStatusList() {
        return [
            User::STATUS_INACTIVE => 'Inactive',
            User::STATUS_ACTIVE => 'Active',
        ];
    }
}
