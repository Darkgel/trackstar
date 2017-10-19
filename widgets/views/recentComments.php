<?php
/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/10/18
 * Time: 21:05
 */
?>
<ul>
    <?php foreach ($comments as $comment):?>
    <div class="author">
        <?php echo $comment['author']?> added a comment.
    </div>
    <div class="issue">
        <?php echo \yii\helpers\Html::a($comment['issueName'], ['issue/view', 'id'=>$comment['issueId']]);?>
    </div>
    <?php endforeach;?>
</ul>
