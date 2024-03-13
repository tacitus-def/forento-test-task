<?php

use yii\db\Migration;

/**
 * Class m240313_125131_alter_table_user
 */
class m240313_125131_alter_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string(50)->null());
        $this->alterColumn('{{%user}}', 'password_hash', $this->string()->null());
        $this->alterColumn('{{%user}}', 'sex', $this->boolean()->null());
        $this->alterColumn('{{%user}}', 'auth_key', $this->string(32)->null());
        $this->addColumn('{{%user}}', 'type_is', $this->smallInteger()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240313_125131_alter_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240313_125131_alter_table_user cannot be reverted.\n";

        return false;
    }
    */
}
