<?php

namespace app\models\ar;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\ar\base\CommonActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class Project extends CommonActiveRecord
{
    private $projectUserRoleTable = '{{%project_user_role}';
    private $projectUserAssignmentTable = '{{%project_user_assignment}';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['name', 'description'],'required'],
            [['id', 'name', 'description', 'create_time', 'update_time', 'create_user_id', 'update_user_id'], 'safe', 'on'=>'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User ID',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['project_id'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%project_user_assignment}}', ['project_id' => 'id']);
    }

    /**
     * @return array of valid users for this project, indexed by user IDs
     */
    public function getUserArr(){
        $usersArray = ArrayHelper::map(
            $this->getUsers()->asArray()->all(),
            'id',
            'username'
        );

        return $usersArray;
    }

    /**
     * 将用户加入到项目中的时候，需要调用该方法，在数据库表中添加关联
     * @param string $role 角色
     * @param integer $userId 用户id
     * @return  integer sql语句执行后影响的行数
     */
    public function associateUserToRole($role, $userId){
        $sql = 'insert into '.$this->projectUserRoleTable.' (project_id, user_id, role) values (:project_id, :user_id, :role)';
        $params = [
            ':project_id' => $this->id,
            ':user_id' => $userId,
            ':role' => $role,
        ];
        return $this->getDb()->createCommand($sql, $params)->execute();
    }

    /**
     * 当改变用户在项目中的角色，或者从一个项目中项目中移除用户时，需要调用该方法来解除关联
     * @param string $role 角色
     * @param integer $userId 用户id
     * @return integer sql语句执行后影响的行数
     */
    public function removeUserFromRole($role, $userId){
        $sql = 'delete from '.$this->projectUserRoleTable.' where project_id=:project_id and user_id=:user_id and role=:role';
        $params = [
            ':project_id' => $this->id,
            ':user_id' => $userId,
            ':role' => $role,
        ];
        return $this->getDb()->createCommand($sql, $params)->execute();
    }


    /**
     * 从authManager中获取所有可用的角色 
     */
    public function getUserRoleOptions(){
        return Yii::$app->authManager->getRoles();
    }


    public function associateUserToProject($userId){
        $sql = 'insert into '.$this->projectUserAssignmentTable.' values (:project_id, :user_id, :create_time, :create_user_id, :update_time, :update_user_id)';
        $params = [
            ':project_id' => $this->id,
            ':user_id' => $userId,
            ':create_time' => new Expression('NOW()'),
            ':create_user_id' => Yii::$app->user->id,
            ':update_time' => new Expression('NOW()'),
            ':update_user_id' => Yii::$app->user_id,
        ];
        return $this->getDb()->createCommand($sql, $params)->execute();
    }


    public function removeUserToProject($userId){
        $sql = 'delete from '.$this->projectUserAssignmentTable.' where project_id=:project_id and user_id=:user_id';
        $params = [
            ':project_id' => $this->id,
            ':user_id' => $userId,
        ];
        return $this->getDb()->createCommand($sql, $params)->execute();
    }

    public function isUserInProject($userId){
        $sql = 'select project_id from '.$this->projectUserAssignmentTable.' where project_id=:project_id and user_id=:user_id';
        $sqlParams = [
            ':project_id' => $this->id,
            ':user_id' => $userId,
        ];
        $result = $this->getDb()->createCommand($sql, $sqlParams)->queryOne();
        return $result ? true : false;
    }

}
