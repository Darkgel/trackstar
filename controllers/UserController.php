<?php

namespace app\controllers;

use Yii;
use app\models\ar\User;
use app\models\ar\Localauth;
use yii\data\ActiveDataProvider;
use app\controllers\base\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AppController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $authModel = new Localauth();

        if ($model->load(Yii::$app->request->post()) && $authModel->load(Yii::$app->request->post())) {
            //使用事务
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($model->save()){
                    $authModel->user_id = $model->id;
                    $authModel->username = $model->email;
                    if($authModel->validate()){
                        $authModel->password = Yii::$app->getSecurity()->generatePasswordHash($authModel->password);
                        if(!$authModel->save(false)){
                            $error = array_values($authModel->getFirstErrors())[0];
                            throw new \Exception($error);//抛出异常
                        }
                    }
                }else{
                    $error = array_values($model->getFirstErrors())[0];
                    throw new \Exception($error);//抛出异常
                }
            }catch(\Exception $e){
                // 记录回滚（事务回滚）
                $transaction->rollBack();
                Yii::$app->session->setFlash('error',$e->getMessage());
                $authModel->password = '';
                $authModel->password_repeat = '';
                return $this->render('create', [
                    'model' => $model,
                    'authModel' => $authModel,
                ]);
            }
            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'authModel' => $authModel,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $authModel = Localauth::find()->where('user_id=:user_id', ['user_id'=>$id])->one();

        if(empty($model) || empty($authModel)){
            throw new NotFoundHttpException('can not find the user!');
        }

        if ($model->load(Yii::$app->request->post()) && $authModel->load(Yii::$app->request->post())) {
            //使用事务
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if($model->save()){
                    $authModel->user_id = $model->id;
                    $authModel->username = $model->email;
                    if($authModel->validate()){
                        $authModel->password = Yii::$app->getSecurity()->generatePasswordHash($authModel->password);
                        if(!$authModel->save(false)){
                            $error = array_values($authModel->getFirstErrors())[0];
                            throw new \Exception($error);//抛出异常
                        }
                    }
                }else{
                    $error = array_values($model->getFirstErrors())[0];
                    throw new \Exception($error);//抛出异常
                }
            }catch(\Exception $e){
                // 记录回滚（事务回滚）
                $transaction->rollBack();
                Yii::$app->session->setFlash('error',$e->getMessage());
                $authModel->password = '';
                $authModel->password_repeat = '';
                return $this->render('create', [
                    'model' => $model,
                    'authModel' => $authModel,
                ]);
            }
            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'authModel' => $authModel,
            ]);
        }

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
