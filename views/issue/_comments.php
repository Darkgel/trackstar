<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/10/17
 * Time: 19:41
 */
?>
<?php foreach ($comments as $comment):?>
<div class="comment">
    <div class="author">
        <?=$comment->author->username?>
    </div>

    <div class="time">
        on <?=date('F j, Y \a\t h:i a',strtotime($comment->create_time))?>
    </div>

    <div class="content">
        <?=nl2br(\yii\helpers\Html::encode($comment->content))?>
    </div>
</div>
<?php endforeach;?>