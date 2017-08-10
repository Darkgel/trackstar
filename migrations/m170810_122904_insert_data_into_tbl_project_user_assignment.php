<?php

use yii\db\Migration;

class m170810_122904_insert_data_into_tbl_project_user_assignment extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '1',
            'user_id' => '1',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '1',
            'user_id' => '2',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '2',
            'user_id' => '1',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '3',
            'user_id' => '2',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '4',
            'user_id' => '1',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);

        $this->insert('{{%project_user_assignment}}',[
            'project_id' => '4',
            'user_id' => '2',
            'create_time' => '2017-08-08 13:33:33',
            'create_user_id' => '1',
            'update_time' => '2017-08-08 13:33:33',
            'update_user_id' => '1',
        ]);
    }

    public function safeDown()
    {
        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=4 and user_id=2'
        );

        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=4 and user_id=1'
        );

        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=3 and user_id=2'
        );

        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=2 and user_id=1'
        );

        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=1 and user_id=2'
        );

        $this->delete(
            '{{%project_user_assignment}}',
            'project_id=1 and user_id=1'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170810_122904_insert_data_into_tbl_project_user_assignment cannot be reverted.\n";

        return false;
    }
    */
}
