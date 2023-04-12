<?php

namespace app\models;

use app\core\Model;

/**
 * @author Yagya
 * @package app\models
 */


class ContactForm extends Model
{
    public string $subject = '';
    public string $email = '';
    public string $body = '';


    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED],
            'body' => [self::RULE_REQUIRED],
        ];
    }


    public function labels(): array
    {
        return [
            'subject' => 'Enter Your subject',
            'email' => 'Enter Email',
            'body' => 'Body',
        ];
    }


    public function send()
    {
        return true;
    }
}
