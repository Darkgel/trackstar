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
class ProjectUserForm extends Model
{
    /**
     * @var User
     */
    public $username;

    public $role;

    /**
     * @var Project
     */
    public $project;


    /**
    * @return array the validation rules.
    */
    public function rules()
    {
        return [
            [['username, role'], 'required'],
            [['username'], 'exist', 'targetClass' => 'app\models\ar\User'],
            [['username'], 'verify'],
        ];
    }

    public function verify($attribute, $params){
        if (!$this->hasErrors()) {
            $user = User::find()->where('username=:username', [':username' => $this->username])->one();
            if($this->project->isUserInProject($user->id)){
                $this->addError('username', 'This user has already been added to the project.');
            }else{
                $this->project->associateUserToProject($user->id);
                $this->project->associateUserToRole($this->role, $user->id);

            }

        }
    }

    /**
    * @return array customized attribute labels
    */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
    * Sends an email to the specified email address using the information collected by this model.
    * @param string $email the target email address
    * @return boolean whether the model passes validation
    */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}