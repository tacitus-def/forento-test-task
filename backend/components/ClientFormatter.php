<?php

namespace backend\components;

use yii\i18n\Formatter;

/**
 * Description of FormattedClient
 *
 * @author demiurg
 */
class ClientFormatter extends Formatter {
    public function asAccountType($value) {
        return ClientMessages::getAccountTypeList()[$value] ?? null;
    }

    public function asStatus($value) {
        return ClientMessages::getStatusList()[$value] ?? null;
    }
}
