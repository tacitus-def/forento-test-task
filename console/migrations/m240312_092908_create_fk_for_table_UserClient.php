<?php

use yii\db\Migration;

/**
 * Class m240312_092908_create_fk_for_table_UserClient
 */
class m240312_092908_create_fk_for_table_UserClient extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_UserClientUserId_UserId', '{{%user_client}}', ['user_id'], '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_UserClientClientId_UserId', '{{%user_client}}', ['client_id'], '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240312_092908_create_fk_for_table_UserClient cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240312_092908_create_fk_for_table_UserClient cannot be reverted.\n";

        return false;
    }
    */
}
