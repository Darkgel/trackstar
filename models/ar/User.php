<?php

namespace app\models\ar;

use Yii;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use app\models\ar\base\CommonActiveRecord;



/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $last_login_time
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property Issue[] $requestIssues
 * @property Issue[] $ownIssues
 * @property Project[] $projects
 */
class User extends CommonActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'username'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['email', 'username'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'username' => 'Username',
            'last_login_time' => 'Last Login Time',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User ID',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestIssues()
    {
        return $this->hasMany(Issue::className(), ['requester_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnIssues()
    {
        return $this->hasMany(Issue::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%project_user_assignment}}', ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException("we don't support this way of login : AccessToken");
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException("we don't support this way of login : AuthKey");
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException("we don't support this way of login : AuthKey");
    }

    public static function findByUsername($username){
        return self::find()->where('username=:username', [':username' => $username])->one();
    }

}
