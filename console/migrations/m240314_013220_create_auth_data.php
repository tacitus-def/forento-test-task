<?php

use yii\db\Migration;
use common\models\Person;

/**
 * Class m240314_013220_create_auth_data
 */
class m240314_013220_create_auth_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $authManager = \Yii::$app->authManager;
        $role_admin = $authManager->createRole('admin');
        $authManager->add($role_admin);

        $admin = new Person([
                'sex' => Person::SEX_MALE,
                'name' => 'Administrator',
                'email' => 'admin@it-crowd.com',
                'status_id' => Person::STATUS_ACTIVE,
                    ]);
        $admin->setPassword('administrator');
        $admin->generateAuthKey();
        $admin->save();
        $authManager->assign($role_admin, $admin->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240314_013220_create_auth_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240314_013220_create_auth_data cannot be reverted.\n";

        return false;
    }
    */
}
