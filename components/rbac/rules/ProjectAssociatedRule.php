<?php
/*
 * @Author: michael.shi 
 * @Date: 2017-08-17 09:27:51 
 * @Last Modified by: michael.shi
 * @Last Modified time: 2017-08-17 10:12:16
 */

namespace app\components\rbac\rules;

use app\components\rbac\models\Rule;
use app\models\ar\Project;


class ProjectAssociatedRule extends Rule
{
    public $name = 'projectAssociated';

    public function execute($user, $item, $params){
        $project = isset($params['project']) ? $params['project'] : NULL;
        if($project instanceof Project){
            return $project->isUserInRole($item->name);
        }

        return false;
    }
}
