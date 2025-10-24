<?php

namespace App\Core;

use PDO;

class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected ?PDO $pdo;
    protected array $customMessages = [];

    public function __construct(array $data = [], array $rules = [], ?PDO $pdo = null, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->pdo = $pdo;
        $this->customMessages = $messages;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $rules = is_array($rules) ? $rules : explode('|', $rules);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                [$name, $params] = $this->parseRule($rule);

                $method = 'validate' . ucfirst($name);
                if (!method_exists($this, $method)) {
                    throw new \Exception("Rule $name not supported");
                }

                $ok = $this->$method($field, $value, $params);
                if (!$ok) {
                    $this->addError($field, $name, $params);
                }
            }
        }

        return empty($this->errors);
    }

    protected function parseRule($rule): array
    {
        if (strpos($rule, ':') === false) return [$rule, []];
        [$name, $paramStr] = explode(':', $rule, 2);
        return [$name, explode(',', $paramStr)];
    }

    protected function addError($field, $rule, $params)
    {
        $msg = $this->customMessages["$field.$rule"]
            ?? $this->defaultMessage($field, $rule, $params);
        $this->errors[$field][] = $msg;
    }

    protected function defaultMessage($field, $rule, $params): string
    {
        $defaults = [
            'required' => "$field Required",
            'email' => "$field Enter a valid email",
            'min' => "$field Should be more than {$params[0]}",
            'max' => "$field Should be less than {$params[0]}",
            'unique' => "$field This is already exists",
            'confirmed' => "Confirmation $field not matched",
            'phone' => "phone number $field not valid",

        ];
        return $defaults[$rule] ?? "$field Not valid";
    }

    /*
     * f=> field  
     * v=> value 
     * p=> params 
     */
    protected function validateRequired($f, $v, $p): bool
    {
        return !($v === null || $v === '');
    }
    protected function validateEmail($f, $v, $p): bool
    {
        return filter_var($v, FILTER_VALIDATE_EMAIL) !== false;
    }
    protected function validateMin($f, $v, $p): bool
    {
        return strlen($v) >= (int)$p[0];
    }
    protected function validateMax($f, $v, $p): bool
    {
        return strlen($v) <= (int)$p[0];
    }

    protected function validateConfirmed($f, $v, $p): bool
    {
        $confirm = $this->data["{$f}_confirmation"] ?? null;
        return $v === $confirm;
    }

    protected function validateUnique($f, $v, $p): bool
    {
        if (!$this->pdo) throw new \Exception("Unique rule requires PDO");
        [$table, $column] = $p;
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `$table` WHERE `$column` = ?");
        $stmt->execute([$v]);
        return $stmt->fetchColumn() == 0;
    }
    function validatePhone($phone)
    {
        // Remove spaces
        $phone = trim($phone);
        // Allow +country code and 10–15 digits
        return preg_match('/^(010|011|012|015)\d{8}$/', $phone);
    }
    // getters
    public function errors(): array
    {
        return $this->errors;
    }
    
    public function fails(): bool
    {
        return !empty($this->errors);
    }
}
