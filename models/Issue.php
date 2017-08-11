<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%issue}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $project_id
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $owner_id
 * @property integer $requester_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property User $requester
 * @property User $owner
 * @property Project $project
 */
class Issue extends \yii\db\ActiveRecord
{
    //issue类型常量($type_id)
    const TYPE_BUG = 0;
    const TYPE_FEATURE = 1;
    const TYPE_TASK = 2;

    //issue状态常量($status_id)
    const STATUS_NOT_BEGIN = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISH = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%issue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['project_id', 'type_id', 'status_id', 'owner_id', 'requester_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 2000],
            [['requester_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['requester_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'project_id' => 'Project ID',
            'type_id' => 'Type',
            'status_id' => 'Status',
            'owner_id' => 'Owner',
            'requester_id' => 'Requester',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequester()
    {
        return $this->hasOne(User::className(), ['id' => 'requester_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public static function getTypeArr(){
        $array = [
            self::TYPE_BUG => 'Bugs',
            self::TYPE_FEATURE => 'Feature',
            self::TYPE_TASK => 'Tasks',
        ];
        return $array;
    }

    public static function getStatusArr(){
        return [
            self::STATUS_NOT_BEGIN => 'Not Yet Started',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_FINISH => 'Finished',
        ];
    }

    public static function getTypeText($type){
        $typeText = 'Unknown Type';
        if(isset(self::getTypeArr()[$type])){
            $typeText = self::getTypeArr()[$type];
        }

        return $typeText;
    }

    public static function getStatusText($status){
        $statusText = 'Unknown Status';
        if(isset(self::getStatusArr()[$status])){
            $statusText = self::getStatusArr()[$status];
        }

        return $statusText;
    }

    /**
     * @param string 'owner' or 'requester'
     * @return string the text of username
     * */
    public function getUsernameText($type){
        $username = 'Not Set';
        if($this->$type != null){
            $username = $this->$type->username;
        }

        return $username;
    }


}
