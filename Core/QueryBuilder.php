<?php

namespace Core;

use Core\Database\Base\BaseDatabase;

class QueryBuilder extends BaseDatabase
{

    public $table;
    public $query;

    public $database;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $this->database = $this->findDatabaseClass();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function select($full_query_or_columns = '*', $table = null)
    {
        $query = new QueryBuilder();
        if (is_null($table)) {
            $table = $query->table;
        }
        if (is_array($full_query_or_columns)) {
            $full_query_or_columns = implode(',', $full_query_or_columns);
        }

        if ($full_query_or_columns == '*') {
            $full_query_or_columns = '*';
        } else {
            $full_query_or_columns = implode(',', $full_query_or_columns);
        }
        if (is_null($table)) {
            $query->query = 'SELECT ' . $full_query_or_columns;
        } else {
            $query->query = 'SELECT ' . $full_query_or_columns . ' FROM ' . $table;
        }
        return $query;
    }

    public static function table($table_name)
    {
        $query = new QueryBuilder();
        $query->table = $table_name;
        return $query;
    }

    public function where($column, $operator, $value = null)
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query .= ' WHERE ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function andWhere($column, $operator, $value = null)
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query .= ' AND ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function orWhere($column, $operator, $value = null)
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query .= ' OR ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function first()
    {
        return $this->database->select($this->query)->fetch();
    }

    public function get()
    {
        return $this->database->select($this->query)->fetchAll();
    }

    public function find($id)
    {
        return $this->database->select($this->query . ' WHERE id = ' . $id)->fetch();
    }

    public function onlyThisColumns($columns = [])
    {
        $this->query = str_replace('*', implode(',', $columns), $this->query);
        return $this;
    }

    public function insert($data)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (';
        $sql .= implode(',', array_keys($data)) . ') VALUES (';
        $sql .= implode(',', array_values($data)) . ')';
        return $this->database->query($sql);
    }

    public function update($data)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ';
        $sql .= implode(',', array_map(function ($key, $value) {
            return $key . ' = ' . $value;
        }, array_keys($data), array_values($data)));
        $sql .= $this->query;
        return $this->database->query($sql);
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . $this->table . $this->query;
        return $this->database->query($sql);

    }




}