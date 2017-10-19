<?php
namespace app\widgets;

/**
 * Created by PhpStorm.
 * User: michael.shi
 * Date: 2017/10/18
 * Time: 20:09
 */
use yii\base\Widget;
use app\models\ar\Comment;

class RecentComments extends Widget
{
    private $_comments;
    public $displayLimit = 5;
    public $projectId = null;

    public function init(){
        parent::init();
        $this->_comments = Comment::findRecentComments($this->displayLimit, $this->projectId);
    }

    public function run(){
        return $this->render('recentComments', [
            'comments' => $this->_comments,
        ]);
    }
}