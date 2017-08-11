<?php

use yii\db\Migration;

class m170811_064822_create_table_localauth extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        // auth table
        $this->createTable('{{%localauth}}', [
            'id' => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'user_id' => "INTEGER NOT NULL",
            'username' => 'VARCHAR(256) NOT NULL',
            'password' => 'VARCHAR(256) NOT NULL',
        ], $tableOptions);

        $this->addForeignKey('FK_auth_user', '{{%localauth}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->insert('{{%localauth}}',[
            'user_id' => '1',
            'username' => 'demo@jfz.com',
            'password' => "MD5('demo')",
        ]);

        $this->insert('{{%localauth}}',[
            'user_id' => '2',
            'username' => 'darkgel@jfz.com',
            'password' => "MD5('darkgel')",
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%localauth}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170811_064822_create_table_localauth cannot be reverted.\n";

        return false;
    }
    */
}
