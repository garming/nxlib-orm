<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 12:41
 */

namespace NxLib\RdsOrm\Lib\Mysql;


use NxLib\RdsOrm\Lib\CURDInterface;
use NxLib\RdsOrm\Lib\EmpFunc;

class CURD implements CURDInterface
{
    private $conn = null;

    private $sql;
    private $table;

    public function __construct($flag)
    {
        $this->conn = Connect::getConnection($flag);
        if(empty($this->conn)){
            $this->conn = new EmpFunc();
        }
    }

    public function query($sql,$bindParam = [])
    {
        if(empty($sql)){
            return null;
        }
        $sth = $this->conn->prepare($sql);
        if(!empty($bindParam)){
            $i = 1;
            foreach ($bindParam as $k => $v){
                if(is_int($k)){
                    if(is_int($v)){
                        $sth->bindValue($i, $v, \PDO::PARAM_INT);
                    }else{
                        $sth->bindValue($i, $v, \PDO::PARAM_STR);
                    }
                }else{
                    $sth->bindValue($i, $v, \PDO::$k);
                }
                $i++;
            }
        }
        $exec = $sth->execute();
        $this->sql = null;
        $this->table = null;
        if(!$exec){
            return $exec;
        }
        $rs = $sth->fetchAll();
        $last_id = $this->conn->lastInsertId();
        if(strpos($sql,"SELECT") === 0){
            return $rs;
        }
        if(empty($rs) && empty($last_id)){
            return $exec;
        }
        return (empty($last_id) ? $rs : $last_id);
    }

    public function table($name, $alias = '')
    {
        $this->table = [
            'name' => $name,
            'alias' => $alias
        ];
        return $this;
    }

    public function insert(array $data)
    {
        $this->checkSyntax();
        $this->sql[0] = "INSERT INTO {$this->tableName()} (";
        $keys = [];
        $values = [];
        foreach ($data as $k => $v){
            $keys[] = "`{$k}`";
            $values[] = '?';
            $this->sql['bindParam'][] = $v;
        }
        $this->sql[1] = implode(",",$keys);
        $this->sql[2] = ") VALUES (";
        $this->sql[3] = implode(",",$values);
        $this->sql[4] = ");";
        return $this;
    }

//    public function insertMulti(array $fields,array $data)
//    {
//        //todo
//    }
//
//    public function insertExistUpdate(array $data, array $update_data)
//    {
//        //todo
//    }

    public function update(array $data)
    {
        $this->checkSyntax();
        $this->sql[0] = "UPDATE {$this->tableName()} SET";
        $keys = [];
        foreach ($data as $k => $v){
            $keys[] = "`{$k}`=?";
            $this->sql['bindParam'][] = $v;
        }
        $this->sql[1] = implode(",",$keys);
        return $this;
    }

    public function delete()
    {
        $this->checkSyntax();
        $this->sql[0] = "DELETE FROM {$this->tableName()}";
        return $this;
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollBack()
    {
        $this->conn->rollBack();
    }

    public function select($fields = '*')
    {
        $this->checkSyntax();
        if(is_array($fields) && !empty($fields)){
            $values = [];
            foreach ($fields as $v){
                $values[] = "{$v}";
            }
            $fields = implode(',',$values);
        }else{
            $fields = "*";
        }
        $this->sql[0] = "SELECT {$fields} FROM {$this->tableName()}";
        return $this;
    }

    public function where($column, $operation, $value)
    {
        if(in_array(" WHERE ",$this->sql,1)){
            $this->sql[] = " AND {$column}{$operation}?";
            $this->sql['bindParam'][] = $value;
        }else{
            $this->sql[] = " WHERE ";
            $this->sql[] = "{$column}{$operation}?";
            $this->sql['bindParam'][] = $value;
        }
        return $this;
    }

    public function orWhere($column, $operation, $value)
    {
        $this->sql[] = " OR {$column}{$operation}?";
        $this->sql['bindParam'][] = $value;
        return $this;
    }

    public function ljoin($tb, $alias, array $on)
    {
        $table = $this->createTableName($tb,$alias);
        $on = implode("=",$on);
        $this->sql[] = " LEFT JOIN {$table} ON {$on} ";
        return $this;
    }

    public function rjoin($tb, $alias, array $on)
    {
        $table = $this->createTableName($tb,$alias);
        $on = implode("=",$on);
        $this->sql[] = " RIGHT JOIN {$table} ON {$on} ";
        return $this;
    }

    public function order($field, $sort = "ASC")
    {
        $this->sql[] = " ORDER BY {$field} {$sort} ";
        return $this;
    }

    public function group($expression)
    {
        $this->sql[] = " GROUP BY {$expression} ";
        return $this;
    }

    public function having($expression)
    {
        $this->sql[] = " HAVING {$expression} ";
        return $this;
    }

    public function limit($limit = 1, $offset = 0)
    {
        $this->sql[] = " LIMIT {$offset},{$limit} ";
        return $this;
    }

    public function exec()
    {
        $bindParam = isset($this->sql["bindParam"]) ? $this->sql["bindParam"] : [];
        unset($this->sql["bindParam"]);
        ksort($this->sql);
        $sql = implode("",$this->sql);
        return $this->query($sql,$bindParam);
    }

    private function checkSyntax()
    {
        if(isset($this->sql[0]) && !empty($this->sql[0])){
            throw new \PDOException("SQL syntax error!");
        }
        if(!isset($this->table['name']) && !empty($this->table['name'])){
            throw new \PDOException("Syntax error! Table must be set first!");
        }
    }
    private function tableName()
    {
        $table = "`{$this->table['name']}`";
        if(!empty($this->table['alias'])){
            $table .= " AS {$this->table['alias']} ";
        }
        return $table;
    }
    private function createTableName($name,$alias = '')
    {
        $table = "`{$name}`";
        if(!empty($alias)){
            $table .= " AS {$alias} ";
        }
        return $table;
    }
}