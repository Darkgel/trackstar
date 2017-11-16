<?php

use yii\db\Migration;
use app\models\ar\User;

class m170817_032453_insert_data extends Migration
{
    public function safeUp()
    {
        $demo = User::find()->where('username=:username', [':username'=>'demo'])->one();
        $darkgel = User::find()->where('username=:username', [':username'=>'darkgel'])->one();


        //往project_user_role中添加数据
        $this->insert('{{%project_user_role}}',[
            'project_id' => '1',
            'user_id' => $demo->id,
            'role' => 'owner',
        ]);

        $this->insert('{{%project_user_role}}',[
            'project_id' => '1',
            'user_id' => $darkgel->id,
            'role' => 'member',
        ]);

        $this->insert('{{%project_user_role}}',[
            'project_id' => '2',
            'user_id' => $demo->id,
            'role' => 'owner',
        ]);

        $this->insert('{{%project_user_role}}',[
            'project_id' => '3',
            'user_id' => $darkgel->id,
            'role' => 'member',
        ]);

        $this->insert('{{%project_user_role}}',[
            'project_id' => '4',
            'user_id' => $demo->id,
            'role' => 'owner',
        ]);

        $this->insert('{{%project_user_role}}',[
            'project_id' => '4',
            'user_id' => $darkgel->id,
            'role' => 'member',
        ]);

    }

    public function safeDown()
    {
        $this->truncateTable('{{%project_user_role}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170817_032453_insert_data cannot be reverted.\n";

        return false;
    }
    */
}
