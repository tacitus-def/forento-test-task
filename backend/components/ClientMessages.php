<?php

namespace backend\components;

use common\models\Client;

/**
 * Description of ClientMessages
 *
 * @author demiurg
 */
class ClientMessages {
    public static function getAccountTypeList()
    {
        return [
            Client::TYPE_PRIVATE => ' Private',
            Client::TYPE_PUBLIC => 'Public',
            Client::TYPE_LIMITED => 'Limited',
                ];
    }

    public static function getStatusList() {
        return [
            Client::STATUS_INACTIVE => 'Inactive',
            Client::STATUS_ACTIVE => 'Active',
        ];
    }

}
