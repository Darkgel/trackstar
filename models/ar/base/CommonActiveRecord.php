<?php
/**
 * @Author: michael.shi 
 * @Date: 2017-08-14 11:17:01 
 * @Last Modified by: michael.shi
 * @Last Modified time: 2017-08-14 11:37:35
 */

namespace app\models\ar\base;

use yii\db\Expression;
use Yii;

class CommonActiveRecord extends AppActiveRecord
{
    /**
    * prepare create_time, create_user_id, update_time and update_user_id attributes before performing validation
    * @return array
    */
    public function beforeValidate(){
        if($this->getIsNewRecord()){
            $this->create_time = $this->update_time = new Expression('NOW()');
            $this->create_user_id = $this->update_user_id = Yii::$app->user->id;
        }else{
            $this->update_time = new Expression('NOW()');
            $this->update_user_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
    }
}
