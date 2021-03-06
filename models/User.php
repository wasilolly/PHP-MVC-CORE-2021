<?php

namespace app\models;

use app\core\UserModel;
use app\core\DbModel;

class User extends UserModel
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTUVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public int $status = self::STATUS_INACTIVE;

    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
      return 'id';  
    }
    
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT );
        return PARENT::save();  
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' =>  [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
             ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5], [SELF::RULE_MAX, 'max' => 30]],
            'confirmPassword' => [self::RULE_REQUIRED, [SELF::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes(): array
    {
        return $atrribute = ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password'
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname.' '.$this->lastname;
    }
}
