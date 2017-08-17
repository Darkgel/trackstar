<?php
/*
 * @Author: michael.shi 
 * @Date: 2017-08-16 14:25:16 
 * @Last Modified by: michael.shi
 * @Last Modified time: 2017-08-17 10:15:44
 */
   
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\ar\User;
use app\components\rbac\ProjectAssociatedRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        // create the lowest level operations for users
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a new user';
        $auth->add($createUser);

        $readUser = $auth->createPermission('readUser');
        $readUser->description = 'read user profile infomation';
        $auth->add($readUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'update a user\'s infomation';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'remove a user from a project';
        $auth->add($deleteUser);



        // create the lowest level operations for projects
        $createProject = $auth->createPermission('createProject');
        $createProject->description = 'Create a new project';
        $auth->add($createProject);

        $readProject = $auth->createPermission('readProject');
        $readProject->description = 'read project infomation';
        $auth->add($readProject);

        $updateProject = $auth->createPermission('updateProject');
        $updateProject->description = 'update project infomation';
        $auth->add($updateProject);

        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'delete a project';
        $auth->add($deleteProject);

        

        // create the lowest level operations for projects
        $createIssue = $auth->createPermission('createIssue');
        $createIssue->description = 'Create a new issue';
        $auth->add($createIssue);

        $readIssue = $auth->createPermission('readIssue');
        $readIssue->description = 'read issue infomation';
        $auth->add($readIssue);

        $updateIssue = $auth->createPermission('updateIssue');
        $updateIssue->description = 'update issue infomation';
        $auth->add($updateIssue);

        $deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'delete a issue from a project';
        $auth->add($deleteIssue);


        
        //create the reader role 
        $reader = $auth->createRole('reader');
        $reader->description = "Reader";
        $auth->add($reader);
        $auth->addChild($reader, $readUser);
        $auth->addChild($reader, $readProject);
        $auth->addChild($reader, $readIssue);


        //create rule ProjectAssociatedRule
        $projectAssociatedRule = new ProjectAssociatedRule();
        $auth->add($projectAssociatedRule);


        //create the member role 
        $member = $auth->createRole('member');
        $member->description = "Member";
        $member->ruleName = $projectAssociatedRule->name;
        $auth->add($member);
        $auth->addChild($member, $reader);
        $auth->addChild($member, $createIssue);
        $auth->addChild($member, $updateIssue);
        $auth->addChild($member, $deleteIssue);


        //create the owner role 
        $owner = $auth->createRole('owner');
        $owner->description = "Owner";
        $auth->add($owner);
        $auth->addChild($owner, $reader);
        $auth->addChild($owner, $member);
        $auth->addChild($owner, $createUser);
        $auth->addChild($owner, $updateUser);
        $auth->addChild($owner, $deleteUser);
        $auth->addChild($owner, $createProject);
        $auth->addChild($owner, $updateProject);
        $auth->addChild($owner, $deleteProject);

    }


    public function actionAssign(){
        $auth = Yii::$app->authManager;
        $auth->removeAllAssignments();

        $authRole = $auth->getRole('member');
        $user = User::find()->where('username=:username', [':username' => 'darkgel'])->one();
        $auth->assign($authRole, $user->id);

        $authRole = $auth->getRole('owner');
        $user = User::find()->where('username=:username', [':username' => 'demo'])->one();
        $auth->assign($authRole, $user->id);

        $authRole = $auth->getRole('reader');
        $user = User::find()->where('username=:username', [':username' => 'test'])->one();
        $auth->assign($authRole, $user->id);
    }

}