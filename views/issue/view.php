<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Issue;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project', 'url' => ['project/view', 'id' => $model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'pid' => $model->project_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:html',
            'description:html',
            'project_id',
            [
                'attribute' => 'type_id',
                'value' => Issue::getTypeText($model['type_id']),
            ],
            [
                'attribute' => 'status_id',
                'value' => Issue::getStatusText($model['status_id']),
            ],
            [
                'attribute' => 'owner_id',
                'value' => Html::encode($model->getUsernameText('owner')),
            ],
            [
                'attribute' => 'requester_id',
                'value' => Html::encode($model->getUsernameText('requester')),
            ],
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
