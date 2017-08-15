<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\db\Expression;
use app\models\ar\Localauth;
use app\models\ar\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginFormByLocalAuth extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * @var Localauth | bool
     */
    private $_userAuth = false;

    /**
     * @var User | bool
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $userAuth = $this->getUserAuth();

            if (!$userAuth || !$userAuth->validatePassword($this->username ,$this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            //将登录状态记录到Yii::$app->user中，并且更新User实例的last_login_time
            if(Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0) && 
                $user->updateAttributes(['last_login_time' => new Expression('NOW()')])){
                    return true;
            }else{
                return false;
            }
            
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Localauth|null
     */
    public function getUserAuth()
    {
        if ($this->_userAuth === false) {
            $this->_userAuth = Localauth::findByUsername($this->username);
        }

        return $this->_userAuth;
    }

    /**
     * 获取User profile 实例 
     * 
     * @return User
     * @throws Exception
     */
    public function getUser(){
        if ($this->_user === false) {
            $this->_user = User::findOne($this->_userAuth->user_id);
        }

        if($this->_user === null){
            throw new Exception('can\'t not find the user record associated to the local auth record!');
        }

        return $this->_user;
    }
}
