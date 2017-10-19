<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\grid\GridView;
use app\widgets\RecentComments;

/* @var $this yii\web\View */
/* @var $model app\models\ar\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->can('updateProject', ['project'=>$model])):?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>

        <?php if(Yii::$app->user->can('deleteProject', ['project'=>$model])):?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>

        <?php if(Yii::$app->user->can('addUser', ['project'=>$model])):?>
        <?= Html::a('Add Member', ['add-member', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php endif;?>

        <?php if(Yii::$app->user->can('createIssue', ['project'=>$model])):?>
        <?= Html::a('Create Issue', ['issue/create', 'pid' => $model->id], ['class' => 'btn btn-info pull-right']) ?>
        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'create_time',
            'create_user_id',
            'update_time',
            'update_user_id',
        ],
    ]) ?>

    <hr/>
    <h3>Members</h3>
    <?=GridView::widget([
        'dataProvider' => $members,
        'columns' => [
            'uid',
            'username',
            'role',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    switch($action){
                        case 'delete':
                            return Yii::$app->urlManager->createUrl(['project/delete-member','id'=>$model['project_id'],'uid'=>$model['uid'],'role'=>$model['role']]);
                            break;
                    }
                },
                'visibleButtons' => [
                    'delete'=> \Yii::$app->user->can('deleteUser',['project'=>$model]),
                ],
             ],
        ],
    ]);?>

    <?php if(Yii::$app->user->can('readIssue', ['project'=>$model])):?>
    <hr/>
    <h3>All Issues</h3>
    <?= ListView::widget([
        'dataProvider' => $issueDataProvider,
        'itemView' => '//issue/_issueListItem',
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
    ]);?>
    <?php endif;?>

</div>

<?php echo RecentComments::widget(['projectId'=>$model->id]);?>
