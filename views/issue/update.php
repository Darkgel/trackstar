<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */

$this->title = 'Update Issue: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="issue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userOptions' => $userOptions,
    ]) ?>

</div>
