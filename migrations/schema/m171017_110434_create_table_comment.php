<?php

use yii\db\Migration;

class m171017_110434_create_table_comment extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%comment}}',[
            'id' => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'content' => "TEXT NOT NULL",
            'issue_id' => 'INTEGER',
            'create_time' => 'DATETIME',
            'create_user_id' => 'INTEGER',
            'update_time' => 'DATETIME',
            'update_user_id' => 'INTEGER',
            'FOREIGN KEY ([[issue_id]]) REFERENCES {{%issue}} ([[id]])',
            'FOREIGN KEY ([[create_user_id]]) REFERENCES {{%user}} ([[id]])',
            'FOREIGN KEY ([[update_user_id]]) REFERENCES {{%user}} ([[id]])',
        ],$tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%content}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171017_110434_create_table_comment cannot be reverted.\n";

        return false;
    }
    */
}
