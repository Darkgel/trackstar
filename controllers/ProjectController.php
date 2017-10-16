<?php

namespace app\controllers;

use Yii;
use app\models\ar\Project;
use yii\data\ActiveDataProvider;
use app\controllers\base\AppController;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ar\Issue;
use yii\helpers\ArrayHelper;
use app\models\form\ProjectUserRoleForm;
use app\models\ar\User;
use yii\db\Query;

/**
 * ProjectController implements the CRUD actions for Projects model.
 */
class ProjectController extends AppController
{
    private $projectUserRoleTable = '{{%project_user_role}}';

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
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Project::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $project = $this->findModel($id);
        $issueDataProvider = new ActiveDataProvider([
            'query' => Issue::find()->where('project_id=:project_id', [':project_id' => $id, ])->asArray(),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        $query = new Query();
        $query->select('id as uid,username,role,project_id')
            ->from('{{%user}}')
            ->innerJoin('{{%project_user_role}}', '{{%user}}.id={{%project_user_role}}.user_id')
            ->where('project_id=:project_id', [':project_id'=>$id]);

        $members = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('view', [
            'model' => $project,
            'issueDataProvider' => $issueDataProvider,
            'members' => $members,
        ]);
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Projects model.
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
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddMember($id){
        $form = new ProjectUserRoleForm();
        $project = $this->findModel($id);

        if($form->load(Yii::$app->request->post())){
            $form->project = $project;

            if($form->validate() && $form->save()){
                Yii::$app->session->setFlash('success', $form->username.' has been added to the project.');
                return $this->redirect(['view', 'id'=>$id]);
            }
        }

        $users = User::find()->select('username')->asArray()->all();
        $usernames = ArrayHelper::getColumn($users, 'username');

        $form->project = $project;
        return $this->render('adduser', [
            'model' => $form,
            'usernames' => $usernames,
        ]);
    }

    public function actionDeleteMember($id, $uid, $role){
        $sql = "delete from ".$this->projectUserRoleTable." where project_id=:project_id and user_id=:user_id and role=:role";
        $params = [
            ':project_id' => $id,
            ':user_id' => $uid,
            ':role' => $role,
        ];

        $result = Yii::$app->db->createCommand($sql, $params)->execute();

        if($result){
            Yii::$app->session->setFlash('success', 'the selected user has been removed from project.');
        }else{
            Yii::$app->session->setFlash('fail', 'the selected user has been removed from project.');
        }

        return $this->redirect(['view', 'id'=>$id]);
    }
}
