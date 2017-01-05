<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $repeat_password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['old_password', 'new_password' , 'repeat_password'], 'required'],
            [['old_password', 'new_password' , 'repeat_password'], 'string', 'max' => 34],
            ['old_password', 'validatePassword'],
            ['repeat_password', 'compare', 'compareAttribute'=> 'new_password', 'message'=> "Repeat password doesn't match."]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => 'Old Password',
            'new_password' => 'New Password',
            'repeat_password' => 'Repeat new password'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if (md5($this->old_password) != Yii::$app->user->identity->password_hash) {
                $this->addError($attribute, 'Incorrect old password.');
            }
        }
    }

    public function changePassword()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->password_hash = md5($this->new_password);
        if($user->save(false)) return true;
        return false;
    }
}
