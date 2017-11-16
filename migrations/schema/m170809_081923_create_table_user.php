<?php

use yii\db\Migration;

class m170809_081923_create_table_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        // user table
        $this->createTable('{{%user}}', [
            'id' => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'email' => "VARCHAR(256) NOT NULL",
            'username' => 'VARCHAR(256)',
            'password' => 'VARCHAR(256)',
            'last_login_time' => 'DATETIME',
            'create_time' => 'DATETIME',
            'create_user_id' => 'INTEGER',
            'update_time' => 'DATETIME',
            'update_user_id' => 'INTEGER',
        ], $tableOptions);

        $this->insert('{{%user}}',[
            'email' => 'demo@jfz.com',
            'username' => 'demo',
            'password' => '$13$YWKRPoGgAgMok2S9vTcfr.g1iruvbXGlfWnIDdEENeQMIuSkVamra',
        ]);
        $this->insert('{{%user}}',[
            'email' => 'darkgel@jfz.com',
            'username' => 'darkgel',
            'password' => '$13$0sWCYYxoDs4oNzwxqe7yOO/huXqk/FXiYvTcmcTEb3tyUwe0seZEG',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170809_081923_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
