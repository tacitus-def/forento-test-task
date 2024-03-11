<?php

use yii\db\Migration;

/**
 * Class m240311_174841_create_table_client
 */
class m240311_174841_create_table_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `account_type` int(11) NOT NULL DEFAULT 1,
  `balance` double DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) DEFAULT 1,
  `deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `client`
  ADD KEY `idx_clientDeleted` (`deleted`),
  ADD KEY `idx_clientStatus` (`status`),
  ADD KEY `idx_clientAccountType` (`account_type`);
         */
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'account_type' => $this->integer()->notNull()->defaultValue(1),
            'balance' => $this->double()->notNull()->defaultValue(0),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB');

        $this->createIndex('idx_clientDeleted', '{{%client}}', ['deleted']);
        $this->createIndex('idx_clientStatus', '{{%client}}', ['status']);
        $this->createIndex('idx_clientAccountType', '{{%client}}', ['account_type']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240311_174841_create_table_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240311_174841_create_table_client cannot be reverted.\n";

        return false;
    }
    */
}
