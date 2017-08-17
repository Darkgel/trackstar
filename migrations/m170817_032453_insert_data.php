<?php

use yii\db\Migration;
use app\models\ar\User;

class m170817_032453_insert_data extends Migration
{
    public function safeUp()
    {
        $demo = User::find()->where('username=:username', [':username'=>'demo'])->one();
        $darkgel = User::find()->where('username=:username', [':username'=>'darkgel'])->one();
        $test = User::find()->where('username=:username', [':username'=>'test'])->one();


        //将test用户与project 1 关联
        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '1',
            'user_id' => $test->id,
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

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

        $this->insert('{{%project_user_role}}',[
            'project_id' => '1',
            'user_id' => $test->id,
            'role' => 'reader',
        ]);
    }

    public function safeDown()
    {
        $this->truncateTable('{{%project_user_role}');

        $test = User::find()->where('username=:username', [':username'=>'test'])->one();
        $this->delete('{{%project_user_assignmnet}','project_id=1 and user_id=:user_id', [
            ':user_id' => $test->id,
        ]);
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
