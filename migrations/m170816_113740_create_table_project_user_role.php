<?php

use yii\db\Migration;

class m170816_113740_create_table_project_user_role extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%project_user_role}}',[
            'project_id' => 'INTEGER NOT NULL',
            'user_id' => 'INTEGER NOT NULL',
            'role' => 'VARCHAR(64) NOT NULL',
            'PRIMARY KEY ([[project_id]],[[user_id]],[[role]])',
            'FOREIGN KEY ([[project_id]]) REFERENCES {{%project}} ([[id]])',
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]])',
            'FOREIGN KEY ([[role]]) REFERENCES {{%auth_item}} ([[name]])',
        ],$tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%project_user_role}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170816_113740_create_table_project_user_role cannot be reverted.\n";

        return false;
    }
    */
}
