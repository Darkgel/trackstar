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
    public function beforeAction($action)
    {
        $projectId = null;
        if(isset($_GET['pid'])){
            $projectId = $_GET['pid'];
        }else{
            if(isset($_POST['pid'])){
                $projectId = $_POST['pid'];
            }
        }
        $this->owner->loadProject($projectId);
        return parent::beforeAction($action);
    }
}