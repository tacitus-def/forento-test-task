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
        return UserLabels::getStatusList()[$value] ?? null;
    }

    public function asSex($value) {
        return UserLabels::getSexList()[$value] ?? null;
    }

    public function asType($value) {
        return UserLabels::getTypeList()[$value] ?? null;
    }
}
