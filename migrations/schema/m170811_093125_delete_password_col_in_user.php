<?php

use yii\db\Migration;

class m170811_093125_delete_password_col_in_user extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'password');
    }

    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'password', 'VARCHAR(256)');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170811_093125_delete_password_col_in_user cannot be reverted.\n";

        return false;
    }
    */
}
