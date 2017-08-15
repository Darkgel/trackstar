<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ar\Issue;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(Issue::getTypeArr());?>

    <?= $form->field($model, 'status_id')->dropDownList(Issue::getStatusArr());?>

    <?= $form->field($model, 'owner_id')->dropDownList($userOptions) ?>

    <?= $form->field($model, 'requester_id')->dropDownList($userOptions) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
