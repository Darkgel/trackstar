<?php

use yii\db\Migration;
use yii\db\Schema;

class m170808_114802_create_table_project extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        // project table
        $this->createTable('{{%project}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING ."(128)",
            'description' => Schema::TYPE_TEXT,
            'create_time' => Schema::TYPE_DATETIME,
            'create_user_id' => Schema::TYPE_INTEGER,
            'update_time' => Schema::TYPE_DATETIME,
            'update_user_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170808_114802_create_table_project cannot be reverted.\n";

        return false;
    }
    */
}
