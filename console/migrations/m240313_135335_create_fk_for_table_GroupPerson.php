<?php

use yii\db\Migration;

/**
 * Class m240313_135335_create_fk_for_table_GroupPerson
 */
class m240313_135335_create_fk_for_table_GroupPerson extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_GroupPersonGroupId_UserId', '{{%group_person}}', ['group_id'], '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_GroupPersonPersonId_UserId', '{{%group_person}}', ['person_id'], '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240313_135335_create_fk_for_table_GroupPerson cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240313_135335_create_fk_for_table_GroupPerson cannot be reverted.\n";

        return false;
    }
    */
}
