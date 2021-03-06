<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\form\LoginFormByLocalAuth;
use app\models\form\ContactForm;

class SiteController extends Controller
{
    public $defaultAction = 'login';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     *
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //在这里可以有多种登录方法，目前只是实现了通过用户名和密码的方式
        return $this->loginByLocalAuth();
    }

    /**
     * 通过本地密码验证方式登录
     */
    public function loginByLocalAuth(){
        if(!Yii::$app->user->isGuest){
            return $this->redirect(Yii::$app->homeUrl);
        }

        $model = new LoginFormByLocalAuth();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTest(){
        $hash0 = Yii::$app->getSecurity()->generatePasswordHash('demo');
        $hash1 = Yii::$app->getSecurity()->generatePasswordHash('darkgel');
        echo $hash0.'<br/>'.$hash1;

//        var_dump(Yii::$app->authManager->getRoles());

//        $users = \app\models\ar\User::find()->all();
//        $usernames = [];
//        foreach ($users as $user){
//            $usernames[] = $user->username;
//        }
//
//        var_dump($usernames);
//
//        $users = \app\models\ar\User::find()->select('username')->asArray()->all();
//
//        var_dump(\yii\helpers\ArrayHelper::getColumn($users, 'username'));


    }
}
