<?php

namespace Core\Table;

use Core\Database\Database;

class Table
{

    protected $table;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Model', '', $class_name));
        }
    }

    public function find($id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function query($statement, $attribute = null, $one = false, $class_name = true)
    {
        if ($attribute && $class_name) {
            return $this->db->prepare(
                $statement,
                $attribute,
                str_replace('Model', 'Entity', get_class($this)),
                $one
            );
        } elseif ($attribute && !$class_name) {
            return $this->db->prepare(
                $statement,
                $attribute,
                null,
                $one
            );
        } elseif (!$class_name) {
            return $this->db->query(
                $statement
            );
        } else {
            return $this->db->query(
                $statement,
                str_replace('Model', 'Entity', get_class($this))
            );
        }
    }

    public function update($id, $fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE {$this->table} SET $sql_part WHERE id = ?", $attributes, true);
    }

    public function deleteComments($id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function create($fields)
    {
        $sql_parts = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO {$this->table} SET $sql_part", $attributes, true);
    }

    public function extract($key, $value)
    {
        $records = $this->all();
        $return = [];
        foreach ($records as $v) {
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }

    public function all()
    {
        return $this->query("SELECT * FROM " . $this->table);
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}