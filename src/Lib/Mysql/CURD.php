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
    private $is_select_one = 0;
    private $is_count = 0;

    public function __construct($flag)
    {
        $this->conn = Connect::getConnection($flag);
        if (empty($this->conn)) {
            $this->conn = new EmpFunc();
        }
    }

    public function query($sql, $bindParam = [])
    {
        if (empty($sql)) {
            return null;
        }
        $sth = $this->conn->prepare($sql);
        if (!empty($bindParam)) {
            $i = 1;
            foreach ($bindParam as $k => $v) {

                if (is_int($k)) {
                    if (is_int($v)) {
                        $sth->bindValue($i, $v, \PDO::PARAM_INT);
                    } else {
                        $sth->bindValue($i, $v, \PDO::PARAM_STR);
                    }
                } else {
                    $sth->bindValue($i, $v, \PDO::$k);
                }
                $i++;
            }
        }
        $exec = $sth->execute();
        $this->sql = null;
        $this->table = null;
        if (!$exec) {
            return $exec;
        }
        if (strpos($sql, "SELECT") === 0 || strpos($sql, "select") === 0) {
            $rs = $sth->fetchAll(\PDO::FETCH_ASSOC);
            if ($this->is_select_one) {
                return (isset($rs[0]) ? $rs[0] : []);
            }
            if ($this->is_count) {
                return (isset($rs[0]['count_num']) ? intval($rs[0]['count_num']) : 0);
            }
            return $rs;
        }
        $last_id = 0;
        if (strpos($sql, "INSERT") === 0) {
            $last_id = $this->conn->lastInsertId();
        }
        if (empty($rs) && empty($last_id)) {
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
        $this->checkEmptyData($data,'Insert');
        $this->checkSyntax();
        $this->sql[0] = "INSERT INTO {$this->tableName()} (";
        $keys = [];
        $values = [];
        foreach ($data as $k => $v) {
            $keys[] = "`{$k}`";
            $values[] = '?';
            $this->sql['bindParam'][] = $v;
        }
        $this->sql[1] = implode(",", $keys);
        $this->sql[2] = ") VALUES (";
        $this->sql[3] = implode(",", $values);
        $this->sql[4] = ")";
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     * will return the first insert id
     */
    public function insertMulti(array $data)
    {
        $this->checkEmptyData($data,'insertMulti');
        $this->checkSyntax();
        if(!is_array($data[0])){
            throw new \PDOException("InsertMulti Data format error! Data format must be \r\n [[\"key\" => \"value\"]]");
        }
        //check column
        $header = array_keys($data[0]);
        $values = [];
        foreach ($data as $one_row){
            $one_column_value = [];
            foreach ($one_row as $k => $v){
                if(!in_array($k,$header)){
                    throw new \PDOException("InsertMulti Data format error! array keys of element must be same");
                }
                $one_column_value[] .= '?';
                $this->sql['bindParam'][] = $v;
            }
            $one_column_value = implode(",",$one_column_value);
            $values[] = "({$one_column_value})";
        }
        $this->sql[0] = "INSERT INTO {$this->tableName()} (";

        foreach ($header as &$column){
            $column = "`{$column}`";
        }
        $this->sql[1] = implode(",", $header);
        $this->sql[2] = ") VALUES ";
        $this->sql[3] = implode(",", $values);
        $this->sql[4] = " ;";
        return $this;
    }

    public function insertExistUpdate(array $data, array $update_data = [])
    {
        $this->insert($data);

        $keys = [];
        if(empty($update_data)){
            $update_data = $data;
        }else{
            $this->checkEmptyData($update_data,'InsertExistUpdate update');
        }
        foreach ($update_data as $k => $v) {
            $keys[] = "`{$k}`=?";
            $this->sql['bindParam'][] = $v;
        }
        $this->sql[] = " ON DUPLICATE KEY UPDATE ";
        $this->sql[] = implode(",", $keys);
        return $this;
    }

    public function update(array $data)
    {
        $this->checkEmptyData($data,'Update');
        $this->checkSyntax();
        $this->sql[0] = "UPDATE {$this->tableName()} SET";
        $keys = [];
        foreach ($data as $k => $v) {
            $keys[] = "`{$k}`=?";
            $this->sql['bindParam'][] = $v;
        }
        $this->sql[1] = implode(",", $keys);
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
        if (is_array($fields) && !empty($fields)) {
            $values = [];
            foreach ($fields as $v) {
                $values[] = "{$v}";
            }
            $fields = implode(',', $values);
        } else {
            $fields = "*";
        }
        $this->sql[0] = "SELECT {$fields} FROM {$this->tableName()}";
        return $this;
    }

    public function selectOne($fields = '*')
    {
        $this->is_select_one = 1;
        return $this->select($fields);
    }

    public function count()
    {
        $field = ['count(*) as count_num'];
        $this->is_count = 1;
        return $this->select($field);
    }

    public function where($column, $operation, $value)
    {
        if (in_array(" WHERE ", $this->sql, 1)) {
            $this->sql[] = " AND {$column}{$operation}?";
            $this->sql['bindParam'][] = $value;
        } else {
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

    /**
     * @param $tb
     * @param $alias
     * @param array $on ["column" => "value"]
     * @return $this
     */
    public function ljoin($tb, $alias, array $on)
    {
        $table = $this->createTableName($tb, $alias);
        $condition = $this->joinConditionHandler($on);
        $this->sql[] = " LEFT JOIN {$table} ON {$condition} ";
        return $this;
    }

    /**
     * @param $tb
     * @param $alias
     * @param array $on ["column" => "value"]
     * @return $this
     */
    public function rjoin($tb, $alias, array $on)
    {
        $table = $this->createTableName($tb, $alias);
        $condition = $this->joinConditionHandler($on);
        $this->sql[] = " RIGHT JOIN {$table} ON {$condition} ";
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
        console($this->sql);
        $sql = implode("", $this->sql);
        return $this->query($sql, $bindParam);
    }

    public function closeAutoCommit()
    {
        $this->conn->setAttribute(\PDO::ATTR_AUTOCOMMIT, 0);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function openAutoCommit()
    {
        $this->conn->setAttribute(\PDO::ATTR_AUTOCOMMIT, 1);
    }

    public function autoTransaction()
    {
        $this->closeAutoCommit();
        $this->beginTransaction();
    }

    public function autoRollBack()
    {
        $this->rollBack();
        $this->openAutoCommit();
    }

    public function autoCommit()
    {
        $this->commit();
        $this->openAutoCommit();
    }

    private function checkSyntax()
    {
        if (isset($this->sql[0]) && !empty($this->sql[0])) {
            throw new \PDOException("SQL syntax error!");
        }
        if (!isset($this->table['name']) && !empty($this->table['name'])) {
            throw new \PDOException("Syntax error! Table must be set first!");
        }
    }

    private function tableName()
    {
        $table = "`{$this->table['name']}`";
        if (!empty($this->table['alias'])) {
            $table .= " AS {$this->table['alias']} ";
        }
        return $table;
    }

    private function createTableName($name, $alias = '')
    {
        $table = "`{$name}`";
        if (!empty($alias)) {
            $table .= " AS {$alias} ";
        }
        return $table;
    }
    private function joinConditionHandler($on)
    {
        $condition = "";
        foreach ($on as $key => $value) {
            $condition .= " {$key}={$value} and";
        }
        $condition = trim($condition, "and");
        return $condition;
    }
    private function checkEmptyData($data,$title){
        if(empty($data)){
            throw new \PDOException("Syntax error! {$title} \$data can not be empty!");
        }
    }
}