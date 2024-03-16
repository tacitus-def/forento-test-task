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
        return ClientLabels::getAccountTypeList()[$value] ?? null;
    }

    public function asStatus($value) {
        return ClientLabels::getStatusList()[$value] ?? null;
    }
}
