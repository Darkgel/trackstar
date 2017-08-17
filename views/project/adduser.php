<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/8/17
 * Time: 20:06
 */

/* @var $this yii\web\View */
/* @var $model app\models\form\ProjectUserForm */
/* @var $usernames array */

use yii\helpers\Html;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use app\models\ar\Project;

$this->title = \Yii::$app->name.' - Add User To Project';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->project->name, 'url' => ['view', 'id' => $model->project->id ]];
$this->params['breadcrumbs'][] = 'Add User';
?>
<?=Html::a('Back To Project', ['view', 'id' => $model->project->id], ['class' => 'btn btn-info pull-right'])?>
<h1>Add User To <?=$model->project->name;?></h1>
<?php if(Yii::$app->session->hasFlash('success')):?>
    <?=Alert::widget([
        'options' => ['class' => 'alert-success'],
        'body' => Yii::$app->session->getFlash('success'),
    ]);?>
<?php endif;?>

<div class="form">
    <?php $form = ActiveForm::begin(); ?>

    <p class="note">Fields with <span style="color: red">*</span> are required</p>

    <?= $form->field($model, 'username')->widget(AutoComplete::classname(), [
        'clientOptions' => [
            'source' => $usernames,
        ],
        'options' => [
            'class' => 'form-control',
        ],
    ]) ?>

    <?= $form->field($model, 'role')->dropDownList(Project::getUserRoleOptions()) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Add User', ['class' => 'btn btn-success']);?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

