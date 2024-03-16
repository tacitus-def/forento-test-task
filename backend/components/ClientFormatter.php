<?php

namespace backend\components;

use common\models\Client;
use yii\i18n\Formatter;

/**
 * Description of FormattedClient
 *
 * @author demiurg
 */
class FormatterClient extends Formatter {
    public function getAccountTypeList()
    {
        return [
            Client::TYPE_PRIVATE => ' Private',
            Client::TYPE_PUBLIC => 'Public',
            Client::TYPE_LIMITED => 'Limited',
                ];
    }

    public function asAccountType($value) {
        return $this->accountTypeList[$value] ?? null;
    }

    public function getStatusList() {
        return [
            Client::STATUS_INACTIVE => 'Inactive',
            Client::STATUS_ACTIVE => 'Active',
        ];
    }

    public function asStatus($value) {
        return $this->statusList[$value] ?? null;
    }
}
