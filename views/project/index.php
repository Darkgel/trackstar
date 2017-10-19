<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\RecentComments;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Projects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'description:ntext',
            'create_time',
            'create_user_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => function($model, $key, $index){
                        return \Yii::$app->user->can('readProject',['project'=>$model]);
                    },
                    'update' => function($model, $key, $index){
                        return \Yii::$app->user->can('updateProject',['project'=>$model]);
                    },
                    'delete' => function($model, $key, $index){
                        return \Yii::$app->user->can('deleteProject',['project'=>$model]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
<?php echo RecentComments::widget();?>
