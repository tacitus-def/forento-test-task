<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string(50)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string(500)->notNull(),
            'sex' => $this->boolean()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted' => $this->boolean()->notNull()->defaultValue(1),
            'auth_key' => $this->string(32)->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB');

        $this->createIndex('idx_userDeleted', '{{%user}}', ['deleted']);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
