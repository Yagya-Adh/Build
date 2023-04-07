<?php

namespace app\core;



abstract class Model
{

    /* validation  rules  constant*/
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public const RULE_UNIQUE = 'unique';


    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value; //
            }
        }
    }

    /* abstract function for setting validation rules */
    abstract public function rules(): array;

    /* labels for userfriendly text */
    public function labels(): array
    {
        return [];
    }

    ///getting labels
    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }



    /* some kind of errors */
    public array $errors = [];

    public function validate()
    {
        /* we gone iterate the  rules() array  from model.php in RegisterModel.php */
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_array($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule); //
                }


                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] =   $this->getLabel($rule['match']);
                    $this->addError($attribute, self::RULE_MATCH, $rule); //
                }


                if ($ruleName === self::RULE_UNIQUE) {

                    $className = $rule['class'];

                    $uniqueAttr = $rule['attribute'] ?? $attribute;

                    $tableName = $className::tableName();

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE  $uniqueAttr = :attr"); /////

                    $statement->bindValue(":attr", $value);

                    $statement->execute();

                    $record = $statement->fetchObject();

                    //already exists message error
                    if ($record) {
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }



    /* errors */
    public function addError(string $attribute, string $rule, $params = [])
    {
        /* replace {min} and {max} with $value in this foreach iteration */
        $message = $this->errorMessages()[$rule] ?? ''; //
        foreach ($params as $key => $value) {
            $message = str_replace("{{key}}", $value, $message); //replace min and max value from here
        }
        $this->errors[$attribute][] = $message;     //
    }


    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this { field } already exists',
        ];
    }




    public function hasError($attribute)
    {
        return  $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}