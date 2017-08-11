<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/8/11
 * Time: 17:46
 */
namespace app\controllers\base;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;

class AppController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ]);
    }
}