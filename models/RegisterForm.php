<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    /*
    - логин
    - пароль
    - ФИО, 
    - телефон, 
    - адрес электронной почты
    
*/
    public string $login = '';
    public string $password = '';
    public string $full_name = '';
    public string $phone = '';
    public string $email = '';
    
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [            
            
            [['login', 'password', 'full_name', 'phone', 'email'], 'required'],
            ['password', 'string', 'min' => 6],
            [['login', 'password', 'full_name', 'phone', 'email'], 'string', 'max' => 255],
            ['full_name', 'match', 'pattern' => '/^[а-яё\s]+$/ui', 'message' => 'Только символы кириллицы и пробелы'],
            
            //+7(XXX)-XXX-XX-XX
            // +7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}
            //
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)-[\d]{3}-[\d]{2}-[\d]{2}$/', 'message' => 'Телефон в формате +7(XXX)-XXX-XX-XX'],
            [['login'], 'unique', 'targetClass' => User::class],

            // email has to be a valid email address
            ['email', 'email'],
            
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [            
            'login' => 'Логин',
            'password' => 'Пароль',
            'full_name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Электронная почта',
        ];
    }

    
    public function userRegister(): bool|object
    {
        if ($this->validate()) {
            $user = new User();
            // $user->login  = $this->login;
            
            $user->attributes = $this->attributes;
            // $user->load($this->attributes, '');

            $user->role_id = Role::getRoleId('user');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if (! $user->save()) {
                Yii::debug($user->errors);
                return false;
            }

            // Yii::debug($user->attributes);
        }

        return $user ?? false;
    }
}
