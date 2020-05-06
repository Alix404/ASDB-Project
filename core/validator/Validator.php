<?php


namespace Core\validator;


use Core\Database\Database;

class Validator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function isAlpha($field, $errorMsg)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function getField($field)
    {
        if (!isset($this->data[$field])) {
            return null;
        }
        return $this->data[$field];
    }

    public function isEmail($field, $errorMsg)
    {
        if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isUniq($field, Database $db, $DBTable, $errorMsg)
    {
        $record = $db->prepare("SELECT id FROM $DBTable WHERE $field = ?", [$this->getField($field)], null, true);
        if ($record) {
            $this->errors[$field] = $errorMsg;
        }
        return $this->errors;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isConfirmed($field, $errorMsg)
    {
        if (empty($this->getField($field)) || $this->getField($field) != $this->getField('confirm_' . $field)) {
            $this->errors[$field] = $errorMsg;
        }
    }
}