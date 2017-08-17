<?php
/*
 * @Author: michael.shi 
 * @Date: 2017-08-17 09:27:51 
 * @Last Modified by: michael.shi
 * @Last Modified time: 2017-08-17 10:12:16
 */

namespace app\components\rbac;

use yii\rbac\Rule;


class ProjectAssociatedRule extends Rule
{
    public $name = 'projectAssociated';
    public $associatedTable = '{{%project_user_assignment}}';
    public $db = 'db';


    public function execute($user, $item, $params){
        if(isset($params['project'])){
            $sql = 'select project_id from '.$this->associatedTable.' where project_id=:project_id and user_id=:user_id';
            $sqlParams = [
                ':project_id' => $params['project']->id,
                ':user_id' => $user,
            ];
            $result = \Yii::$app->get($this->db)->createCommand($sql, $sqlParams)->queryOne();
            return $result ? true : false;
        }

        return false;
    }
}
