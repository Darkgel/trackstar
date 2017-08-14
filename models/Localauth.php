<?php

namespace app\models;

use Yii;
use yii\db\Exception;
use app\components\interfaces\LocalAuthInterface;

/**
 * This is the model class for table "{{%localauth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $password
 *
 * @property User $user
 */
class Localauth extends \yii\db\ActiveRecord implements LocalAuthInterface
{   
    public $password_repeat;    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%localauth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'password'], 'required'],
            [['username'], 'unique'],
            [['user_id'], 'integer'],
            [['username', 'password'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            ['password_repeat', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => "Repeat Password",
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findByUsername($username){
        return self::find()->where('username=:username', [':username' => $username])->one();
    }

    /**
     * 验证登录密码是否正确
     * @param string $username 表单用户名
     * @param string $password 表单密码
     * @return bool
     */
    public function validatePassword($username ,$password)
    {
        $auth = self::find()->where('username=:username', [':username'=>$username])->one();
        if($auth === null){
            return false;
        }

        //验证密码的具体实现
        if (Yii::$app->getSecurity()->validatePassword($password, $auth->password)) {
            // all good, logging user in
            return true;
        } else {
            // wrong password
            return false;
        }
    }
}
