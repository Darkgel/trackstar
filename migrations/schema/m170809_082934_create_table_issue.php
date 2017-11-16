<?php

use yii\db\Migration;

class m170809_082934_create_table_issue extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        // issue table
        $this->createTable('{{%issue}}', [
            'id' => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => "VARCHAR(256) NOT NULL",
            'description' => 'VARCHAR(2000)',
            'project_id' => 'INTEGER',
            'type_id' => 'INTEGER',
            'status_id' => 'INTEGER',
            'owner_id' => 'INTEGER',
            'requester_id' => 'INTEGER',
            'create_time' => 'DATETIME',
            'create_user_id' => 'INTEGER',
            'update_time' => 'DATETIME',
            'update_user_id' => 'INTEGER',
        ], $tableOptions);

        $this->createIndex('idx_project_id', '{{%issue}}', 'project_id');

        $this->addForeignKey('FK_issue_project', '{{%issue}}', 'project_id', '{{%project}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('FK_issue_owner', '{{%issue}}', 'owner_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('FK_issue_requester', '{{%issue}}', 'requester_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('FK_issue_requester', '{{%issue}}');
        $this->dropForeignKey('FK_issue_owner', '{{%issue}}');
        $this->dropForeignKey('FK_issue_project', '{{%issue}}');
        $this->dropIndex('idx_project_id', '{{%issue}}');
        $this->dropTable('{{%issue}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170809_082934_create_table_issue cannot be reverted.\n";

        return false;
    }
    */
}
