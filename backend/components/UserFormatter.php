<?php

namespace backend\components;

use yii\i18n\Formatter;

/**
 * Description of FormatterUser
 *
 * @author demiurg
 */
class UserFormatter extends Formatter {
    public function asStatus($value) {
        return UserMessages::getStatusList()[$value] ?? null;
    }

    public function asSex($value) {
        return UserMessages::getSexList()[$value] ?? null;
    }

    public function asType($value) {
        return UserMessages::getTypeList()[$value] ?? null;
    }
}
