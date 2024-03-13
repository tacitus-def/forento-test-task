<?php

use yii\db\Migration;

/**
 * Class m240313_134647_create_table_GroupPerson
 */
class m240313_134647_create_table_GroupPerson extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group_person}}', [
            'group_id' => $this->integer()->notNull(),
            'person_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pri_GroupPerson', '{{%group_person}}', ['group_id', 'person_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240313_134647_create_table_GroupPerson cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240313_134647_create_table_GroupPerson cannot be reverted.\n";

        return false;
    }
    */
}
