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
use app\components\rbac\rules\ProjectAssociatedRule;
use app\components\rbac\models\Assignment;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        // create the lowest level operations for users
        $createUser = $auth->createPermission('addUser');
        $createUser->description = 'Add a new user to Project';
        $auth->add($createUser);

        $readUser = $auth->createPermission('readMember');
        $readUser->description = 'read user profile information in project';
        $auth->add($readUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'update a user\'s information in project';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'remove a user from a project in project';
        $auth->add($deleteUser);




        //只要是应用的用户就可以createProject
//        $createProject = $auth->createPermission('createProject');
//        $createProject->description = 'Create a new project';
//        $auth->add($createProject);

        // create the lowest level operations for projects
        $readProject = $auth->createPermission('readProject');
        $readProject->description = 'read project information';
        $auth->add($readProject);

        $updateProject = $auth->createPermission('updateProject');
        $updateProject->description = 'update project information';
        $auth->add($updateProject);

        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'delete a project';
        $auth->add($deleteProject);

        

        // create the lowest level operations for projects
        $createIssue = $auth->createPermission('createIssue');
        $createIssue->description = 'Create a new issue';
        $auth->add($createIssue);

        $readIssue = $auth->createPermission('readIssue');
        $readIssue->description = 'read issue information';
        $auth->add($readIssue);

        $updateIssue = $auth->createPermission('updateIssue');
        $updateIssue->description = 'update issue information';
        $auth->add($updateIssue);

        $deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'delete a issue from a project';
        $auth->add($deleteIssue);




        //create rule ProjectAssociatedRule
        $projectAssociatedRule = new ProjectAssociatedRule();
        $auth->add($projectAssociatedRule);

        //create the reader role 
        $reader = $auth->createRole('reader');
        $reader->description = "Reader";
        $auth->add($reader);
        $auth->addChild($reader, $readUser);
        $auth->addChild($reader, $readProject);
        $auth->addChild($reader, $readIssue);

        //create the member role 
        $member = $auth->createRole('member');
        $member->description = "Member";
        $auth->add($member);
        $auth->addChild($member, $reader);
        $auth->addChild($member, $createIssue);
        $auth->addChild($member, $updateIssue);
        $auth->addChild($member, $deleteIssue);


        //create the owner role 
        $owner = $auth->createRole('owner');
        $owner->description = "Owner";
        $auth->add($owner);
        $auth->addChild($owner, $member);
        $auth->addChild($owner, $createUser);
        $auth->addChild($owner, $updateUser);
        $auth->addChild($owner, $deleteUser);
        $auth->addChild($owner, $updateProject);
        $auth->addChild($owner, $deleteProject);

    }


    public function actionAssign(){
        $projectAssociatedRule = new ProjectAssociatedRule();
        $ruleName = $projectAssociatedRule->name;

        $auth = Yii::$app->authManager;
        $auth->removeAllAssignments();

        $assignmentTmp = new Assignment();

        $user = User::find()->where('username=:username', [':username' => 'darkgel'])->one();
        $assignmentTmp->userId = $user->id;
        $assignmentTmp->roleName = 'member';
        $assignmentTmp->ruleName = $ruleName;
        $auth->assign($assignmentTmp);

        $user = User::find()->where('username=:username', [':username' => 'demo'])->one();
        $assignmentTmp->userId = $user->id;
        $assignmentTmp->roleName = 'owner';
        $assignmentTmp->ruleName = $ruleName;
        $auth->assign($assignmentTmp);

//        $user = User::find()->where('username=:username', [':username' => 'test'])->one();
//        $assignmentTmp->userId = $user->id;
//        $assignmentTmp->roleName = 'reader';
//        $assignmentTmp->ruleName = $ruleName;
//        $auth->assign($assignmentTmp);
    }

}