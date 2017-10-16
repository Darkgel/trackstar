<?php
/*
 * @Author: michael.shi 
 * @Date: 2017-08-17 19:22:12 
 * @Last Modified by: michael.shi
 * @Last Modified time: 2017-08-17 19:45:02
 */


namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\ar\User;
use app\models\ar\Project;

/**
* ContactForm is the model behind the contact form.
*/
class ProjectUserRoleForm extends Model
{
    
    public $username;

    public $role;

    /**
     * @var Project
     */
    public $project;

    public $_user = false;


    /**
    * @return array the validation rules.
    */
    public function rules()
    {
        return [
            [['username', 'role'], 'required'],
            [['username'], 'exist', 'targetClass' => 'app\models\ar\User'],
            [['username'], 'verify'],
        ];
    }


    public function verify($attribute, $params){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if($this->project->isUserInProject($user->id)){
                $this->addError($attribute, 'This user has already been added to the project.');
            }
        }
    }

    public function save(){
        $user = $this->getUser();
        if(!empty($user)){
            return $this->project->associateUserToRole($this->role, $user->id);
        }
        return false;
    }

    public function getUser(){
        if($this->_user === false){
            $this->_user = User::find()->where('username=:username', [':username' => $this->username])->one();
        }

        return $this->_user;
    }
}