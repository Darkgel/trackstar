<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/8/9
 * Time: 20:10
 */

namespace app\components;

use yii\base\ActionFilter;

class ProjectContextFilter extends  ActionFilter
{
    private $loadProject = 'loadProject';

    public function beforeAction($action)
    {
        $projectId = null;
        if(isset($_GET['pid'])){
            $projectId = $_GET['pid'];
        }

        call_user_func_array([$this->owner,$this->loadProject],[$projectId]);

        return parent::beforeAction($action);
    }
}