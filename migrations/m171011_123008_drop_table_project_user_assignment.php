<?php

use yii\db\Migration;

class m171011_123008_drop_table_project_user_assignment extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('FK_user_project', '{{%project_user_assignment}}');
        $this->dropForeignKey('FK_project_user', '{{%project_user_assignment}}');
        $this->dropTable('{{%project_user_assignment}}');

    }

    public function safeDown()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        // assignment table
        $this->createTable('{{%project_user_assignment}}', [
            'project_id' => 'INTEGER NOT NULL',
            'user_id' => 'INTEGER NOT NULL',
            'create_time' => 'DATETIME',
            'create_user_id' => 'INTEGER',
            'update_time' => 'DATETIME',
            'update_user_id' => 'INTEGER',
            'PRIMARY KEY (`project_id`,`user_id`)',
        ], $tableOptions);

        $this->addForeignKey('FK_project_user', '{{%project_user_assignment}}', 'project_id', '{{%project}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('FK_user_project', '{{%project_user_assignment}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171011_123008_drop_table_project_user_assignment cannot be reverted.\n";

        return false;
    }
    */
}
