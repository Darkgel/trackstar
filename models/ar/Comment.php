<?php

namespace app\models\ar;

use Yii;

use app\models\ar\base\CommonActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property string $content
 * @property integer $issue_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property Issue $issue
 * @property User $createUser
 * @property User $updateUser
 */
class Comment extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['issue_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issue::className(), 'targetAttribute' => ['issue_id' => 'id']],
            [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_user_id' => 'id']],
            [['update_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'issue_id' => 'Issue ID',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User ID',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issue::className(), ['id' => 'issue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'update_user_id']);
    }

    public static function findRecentComments($limit = 10, $projectId = null){
        $query = (new Query())
            ->select(
                User::tableName().'.username as author,'
                .Issue::tableName().'.name as issueName,'
                .Issue::tableName().'.id as issueId'
            )->from(Comment::tableName())
            ->innerJoin(Issue::tableName(), Comment::tableName().'.issue_id='.Issue::tableName().'.id')
            ->innerJoin(User::tableName(), Comment::tableName().'.create_user_id='.Issue::tableName().'.id')
            ->orderBy(Comment::tableName().'.create_time DESC')
            ->limit($limit);

        if($projectId !== null){
            $query = $query->andWhere('project_id=:projectId', [':projectId'=>$projectId]);
        }

        $result = $query->all();

        return $result;
    }
}
