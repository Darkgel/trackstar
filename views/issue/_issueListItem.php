<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/8/11
 * Time: 11:15
 */
use yii\widgets\DetailView;
use yii\helpers\Html;
use app\models\ar\Issue;
?>
<div class="issue">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'value' => Html::a($model['name'], ['issue/view', 'id'=>$model['id']]),
                'format' => 'html',
            ],
            'description:html',
            [
                'attribute' => 'type_id',
                'value' => Issue::getTypeText($model['type_id']),
            ],
            [
                'attribute' => 'status_id',
                'value' => Issue::getStatusText($model['status_id']),
            ],
        ],
    ]) ?>
</div>