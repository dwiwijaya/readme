<?php

namespace app\models;

use app\helpers\Utils;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "users".
 *
 * @property string|null $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $password
 * @property string|null $bio
 * @property string|null $role
 * @property string|null $authKey
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $lastlogin
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const SCNEARIO_RESET_EMAIL = 'RESET_EMAIL';
    const SCENARIO_RESET_PASSWORD = 'RESET_PASSWORD';
    const SCENARIO_FORGOT_PASSWORD = 'FORGOT_PASSWORD';
    public $confirmPassword;
    public $newPassword;
    public $currentPassword;
    public $newEmail;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currentPassword', 'confirmPassword', 'newPassword'], 'required', 'on' => self::SCENARIO_RESET_PASSWORD],
            [['currentPassword'], 'validatenewPassword', 'on' => self::SCENARIO_RESET_PASSWORD],
            [['newEmail'], 'required', 'on' => self::SCNEARIO_RESET_EMAIL],
            [['newEmail'], 'email'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => "New Passwords don't match"],
            [['username', 'first_name', 'last_name', 'password', 'bio', 'authKey'], 'string'],
            [['created_at', 'updated_at', 'lastlogin', 'profile_picture'], 'safe'],
            [['username'], 'unique']
        ];
    }

    public function validatenewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Yii::$app->getSecurity()->validatePassword(md5($this->currentPassword), $this->password) == false) {
                $this->addError($attribute, 'Incorect Current Password.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password' => 'Password',
            'email' => 'Email',
            'bio' => 'Bio',
            'authKey' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lastlogin' => 'Lastlogin',
        ];
    }

    public function getRole()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'username']);
    }


    public function getPrivilege()
    {
        return $this->role ? $this->role->item_name : null;
    }

    public static function userProfile($id)
    {
        $article = Article::getArticlebyuser($id)->count();
        $follow = Follow::find()->where(['author_id' => $id])->count();

        return [
            'article' => $article,
            'follower' => $follow
        ];
    }

    public static function getUserauthor($model)
    {
        $query = (new Query())
            ->select(['u.*'])
            ->from(['u' => self::tableName()])
            ->innerJoin(['a' => AuthAssignment::find()->where(['item_name' => Utils::ROLE_AUTHOR])], 'u.id=a.user_id')
            ->andFilterWhere(['like', 'upper(username)', strtoupper($model->username)])
            ->andFilterWhere(['like', 'upper(id)', strtoupper($model->id)]);

        return $query;
    }
    public static function getUsereditor($model)
    {
        $query = (new Query())
            ->select(['u.*'])
            ->from(['u' => self::tableName()])
            ->innerJoin(['a' => AuthAssignment::find()->where(['item_name' => Utils::ROLE_EDITOR])], 'u.id=a.user_id')
            ->andFilterWhere(['like', 'upper(username)', strtoupper($model->username)])
            ->andFilterWhere(['like', 'upper(id)', strtoupper($model->id)]);

        return $query;
    }
    public static function getUsersubscriber($model)
    {
        $query = (new Query())
            ->select(['u.*'])
            ->from(['u' => self::tableName()])
            ->innerJoin(['a' => AuthAssignment::find()->where(['item_name' => Utils::ROLE_SUBCRIBER])], 'u.id=a.user_id')
            ->andFilterWhere(['like', 'upper(username)', strtoupper($model->username)])
            ->andFilterWhere(['like', 'upper(id)', strtoupper($model->id)]);

        return $query;
    }
}
