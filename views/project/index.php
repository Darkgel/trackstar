<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            // 'update_time',
            // 'update_user_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'views' => function ($url, $model, $key) {
                        if($model->perms['readProject']){
                            $title = Yii::t('yii', 'View');
                            $options = [
                                'title' => $title,
                                'aria-label' => $title,
                                'data-pjax' => '0',
                            ];
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                            return Html::a($icon, $url, $options);
                        }else{
                            return '';
                        }
                    },
                    'update' => function ($url, $model, $key) {
                        if($model->perms['updateProject']){
                            $title = Yii::t('yii', 'Update');
                            $options = [
                                'title' => $title,
                                'aria-label' => $title,
                                'data-pjax' => '0',
                            ];
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-pencil"]);
                            return Html::a($icon, $url, $options);
                        }else{
                            return '';
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        if($model->perms['deleteProject']){
                            $title = Yii::t('yii', 'Delete');
                            $options = [
                                'title' => $title,
                                'aria-label' => $title,
                                'data-pjax' => '0',
                            ];
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-trash"]);
                            return Html::a($icon, $url, $options);
                        }else{
                            return '';
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
