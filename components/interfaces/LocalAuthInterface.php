<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/8/11
 * Time: 16:15
 */

namespace app\components\interfaces;



Interface LocalAuthInterface
{
    public function validatePassword($username ,$password);
}