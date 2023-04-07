<?php

namespace app\models;

use app\core\DbModel;
// use app\core\Model;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public int $status = self::STATUS_INACTIVE; //


    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';



    public function tableName(): string
    {
        return 'users'; //why users
    }


    public function save()
    {
        // echo "Creating new  user";
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }


    /*abstract function rule() to do  validation rule from model.php  */
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [
                self::RULE_REQUIRED, self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE,
                    'class' => self::class,
                    'attribute' => 'firstname'
                ]
            ],
            //

            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }


    public function attributes(): array
    {
        return ['firstname', 'lstname', 'email', 'password', 'status'];
    }


    public function labels(): array
    {
        return [

            'firstname' => 'First name',
            'lasttname' => 'Last name',
            'email' => 'Your Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password',
        ];
    }
}
