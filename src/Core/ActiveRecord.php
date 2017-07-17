<?php

namespace Core;

use Exception;
use PDO;
use PDOException;

class ActiveRecord
{
    public $host;
    public $db_name;
    public $db_username;
    public $db_password;
    public $dbh;

    function __construct($config = false)
    {
        if (is_array($config)) {
            $this->host = $config['host'];
            $this->db_name = $config['db_name'];
            $this->db_username = $config['db_username'];
            $this->db_password = $config['db_password'];
        }
        try {
            $this->dbh = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
            $this->dbh->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $table
     * @param $insert
     * @return mixed
     */
    public function create($table, $insert)
        //Timestamp always set unless otherwise specified
    {
        // Filter out fields that don't exist
        $insert = $this->filter($insert, $table);
        //End Filter


        $keys = implode(', ', array_keys($insert));
        $table_values = implode(", :", array_keys($insert));
        $sql = "INSERT INTO $table ($keys) VALUES(:$table_values)";
        $query = $this->dbh->prepare($sql);
        $new_insert = array();
        foreach ($insert as $key => $value) {
            if ($value == null) {
                $value = '';
            }
            $new_insert[":" . $key] = $value;
        }
        $query->execute($new_insert);

        //to check that there is an id field before using it to get the last object
        if ($this->dbh->lastInsertId()) {
            $stmt = $this->dbh->query("SELECT * FROM $table WHERE {$this->getPrimaryKey($table)}='" . $this->dbh->lastInsertId() . "'");
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else //if there isn't, just get the object by fields
        {
            return $this->getByWhere($table, $insert);
        }
    }


    /**
     * @param string $table
     * @param array $data
     */
    public function insertDataInTable( string $table, array $data)
    {
        $names = null;
        $values = null;


        foreach ($data as $fieldName => $fieldValue) {
            end($data);
            if ((string) key($data) === (string) $fieldName) {
                $names = $names . "$fieldName";
                $values = $values . ":$fieldName";
            } else {
                $names = $names . "$fieldName, ";
                $values = $values . ":$fieldName, ";
            }
        }

        $sql = "INSERT INTO  `$table` ($names) VALUES ($values)";
        $stmt = $this->dbh->prepare($sql);

        $paramsArray = [];
        foreach ($data as $fieldName => $fieldValue) {
            $paramsArray[":$fieldName"] = $fieldValue;
        }

        if (!$stmt->execute($paramsArray)) {
            echo "\nPDO::errorInfo():\n";
            print_r($stmt->errorInfo());
        }
    }

    public function update($table, array $data, $byId)
    {
        $setData = null;

        foreach ($data as $fieldName => $fieldValue) {
            end($data);
            if ((string) key($data) === (string) $fieldName) {
                $setData .= "$fieldName='$fieldValue'";
            }else {
                $setData .= "$fieldName='$fieldValue', ";
            }
        }

        $sql = "UPDATE `$table` SET $setData WHERE id=$byId";

        $stmt = $this->dbh->prepare($sql);

        if (!$stmt->execute()) {
            echo "\nPDO::errorInfo():\n";
            print_r($stmt->errorInfo());
            echo "<pre>" . var_dump(111) . "</pre>";exit;
        }

    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM `$table` WHERE id=$id";
        $stmt = $this->dbh->exec($sql);
    }

    public function getAllDataInTable($table)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM $table");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * @param $table
     * @param $id
     * @return mixed
     */
    public function getByID($table, $id)
    {
        return $this->getByField($table, $this->getPrimaryKey($table), $id);
    }

    /**
     * @param $table
     * @param $field
     * @param $value
     * @param bool $options
     * @return mixed
     */
    public function getByField($table, $field, $value, $options = false)
    {
        $data = array($field => $value);
        return $this->getByWhere($table, $data, $options);
    }

    /**
     * @param $table
     * @param $data
     * @param bool $options
     * @return mixed
     */
    public function getByWhere($table, $data, $options = false)
    {
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach ($data as $key => $value) {
            if ($value == null) {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            } else {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if ($options) {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $table
     * @param $data
     * @param bool $options
     * @return array
     */
    public function getAllByWhere($table, $data, $options = false)
    {
        $data = $this->filter($data, $table);
        $conditions = array();
        foreach ($data as $key => $value) {
            if ($value == null) {
                $conditions[] = "$key IS NULL";
                unset($data[$key]);
            } else {
                $conditions[] = "$key=?";
            }
        }
        $str = implode(' AND ', $conditions);
        $sql = "SELECT * FROM $table WHERE $str";
        if ($options) {
            $sql .= ' ' . $options;
        }
        $query = $this->dbh->prepare($sql);
        $query->execute(array_values($data));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $insert
     * @param $table
     * @return mixed
     * @throws Exception
     */
    public function filter($insert, $table)
    {
        $columns = $this->dbh->query("SHOW COLUMNS FROM `$table`")->fetchAll();
        $fields = array();
        foreach ($columns as $row) {
            $fields[$row['Field']] = true;
        }

        foreach ($insert as $key => $value) {
            if (!isset($fields[$key])) {
                unset($insert[$key]);
            }
        }

        if (count($insert) === 0) {
            throw new Exception('At least one field must be passed as data.  Check to make sure fields exist in Database');
        }
        return $insert;
    }

    /**
     * @param $table
     * @return mixed
     */
    public function getPrimaryKey($table)
    {
        $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $stmt = $this->dbh->query($sql);
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res->Column_name;
    }

}
