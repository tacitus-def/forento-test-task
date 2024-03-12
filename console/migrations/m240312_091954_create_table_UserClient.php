<?php

use yii\db\Migration;

/**
 * Class m240312_091954_create_table_UserClient
 */
class m240312_091954_create_table_UserClient extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_client}}', [
            'user_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pri_UserClient', '{{%user_client}}', [
            'user_id', 'client_id'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240312_091954_create_table_UserClient cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240312_091954_create_table_UserClient cannot be reverted.\n";

        return false;
    }
    */
}
