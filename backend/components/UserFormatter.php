<?php

namespace backend\components;

use yii\i18n\Formatter;
use common\models\Person;
use common\models\User;

/**
 * Description of FormatterUser
 *
 * @author demiurg
 */
class FormatterUser extends Formatter {
    public function getSexList() {
        return [
            Person::SEX_FEMALE => 'Female',
            Person::SEX_MALE => 'Male',
        ];
    }

    public function getTypeList() {
        return [
            User::TYPE_PERSON => 'Person',
            User::TYPE_GROUP => 'Group',
        ];
    }

    public function getStatusList() {
        return [
            User::STATUS_INACTIVE => 'Inactive',
            User::STATUS_ACTIVE => 'Active',
        ];
    }

    public function asStatus($value) {
        return $this->statusList[$value] ?? null;
    }

    public function asSex($value) {
        return $this->sexList[$value] ?? null;
    }

    public function asType($value) {
        return $this->typeList[$value] ?? null;
    }
}
