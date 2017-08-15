<?php

namespace app\controllers;

use app\models\ar\Project;
use Yii;
use app\models\ar\Issue;
use yii\data\ActiveDataProvider;
use app\controllers\base\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\filters\ProjectContextFilter;
use yii\helpers\ArrayHelper;

/**
 * IssueController implements the CRUD actions for Issue model.
 */
class IssueController extends AppController
{
    //Issue所属的Project
    private $_project = null;

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
            'filterProjectContext' => [
                'class' => ProjectContextFilter::className(),
                'only'=>[
                    'create','update',
                ],
            ],
        ]);
    }

    public  function loadProject($projectId){
        if($this->_project === null){
            $this->_project = Project::findOne($projectId);
            if($this->_project === null){
                throw new NotFoundHttpException('The requested project does not exit!', 404);
            }
        }
        return $this->_project;
    }

    /**
     * @return Project the project model instance to which this issue belongs
      */
    public function getProject(){
        return $this->_project;
    }

    /**
     * Lists all Issue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Issue::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Issue model.
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
     * Creates a new Issue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Issue();
        $model->project_id = $this->_project->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'userOptions' => $this->getProject()->getUserArr(),
            ]);
        }
    }

    /**
     * Updates an existing Issue model.
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
                'userOptions' => $this->getProject()->getUserArr(),
            ]);
        }
    }

    /**
     * Deletes an existing Issue model.
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
     * Finds the Issue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Issue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Issue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
