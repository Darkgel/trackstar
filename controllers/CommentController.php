<?php

namespace app\controllers;

use Yii;
use app\models\ar\Comment;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\base\AppController;
use Zend\Feed\Writer\Feed;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends AppController
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['feed'],
                    ]
                    // everything else is denied
                ],
            ],
        ]);
    }

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comment model.
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
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Comment model.
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
     * Deletes an existing Comment model.
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
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFeed(){
        if(isset($_GET['pid'])){
            $projectId = intval($_GET['pid']);
        }else{
            $projectId = null;
        }

        $comments = Comment::findRecentComments(20,$projectId);

        /**
         * Create the parent feed
         */
        $feed = new Feed;
        $feed->setTitle("Trackstar Project Comments Feed");
        $feed->setLink(Yii::$app->urlManager->createUrl($this->route));
        $feed->setDescription('Trackstar Project Comments Feed Description');
        $feed->setEncoding('UTF-8');

        foreach ($comments as $comment){
            $entry = $feed->createEntry();
            $entry->setTitle($comment['issueName']);
            $entry->setLink(Yii::$app->urlManager->createAbsoluteUrl(['issue/view', 'id'=>$comment['issueId']]));
            $entry->setDateModified(time());
            $entry->setDateCreated(time());
            $entry->setDescription($comment['author'].' says: '.$comment['content']);
            $entry->addAuthor([
                'name'  => $comment['author'],
            ]);
            $feed->addEntry($entry);
        }


        /**
         * Render the resulting feed to Atom 1.0 and assign to $out.
         * You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
         */
        $out = $feed->export('rss');

        return $out;
    }
}
