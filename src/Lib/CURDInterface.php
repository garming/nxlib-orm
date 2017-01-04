<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 11/20/15
 * Time: 10:22
 */

namespace NxLib\RdsOrm\Lib;


interface CURDInterface
{

    /**
     * exec and return the result
     * @param $sql
     * @param array $bindParam
     * @return mixed
     */
    public function query($sql,$bindParam = []);

    public function table($name, $alias = '');

    /**
     * the result will try to return AUTO_INCREMENT ID
     * exec and return the result
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

//    public function insertMulti(array $fields,array $data);
//
//    public function insertExistUpdate(array $data, array $update_data);
    /**
     * exec and return the result
     * @param array $data
     * @return mixed
     */
    public function update(array $data);

    /**
     * exec and return the result
     * @return mixed
     */
    public function delete();

    public function beginTransaction();

    public function commit();

    public function rollBack();

    /**
     * run with exec
     * @param string $fields
     * @return mixed
     */
    public function select($fields = '*');

    public function where($column, $operation, $value);

    public function orWhere($column, $operation, $value);

    public function ljoin($tb, $alias, array $on);

    public function rjoin($tb, $alias, array $on);

    public function order($fields, $sort = "ASC");

    public function group($expression);

    public function having($expression);

    public function limit($limit = 1, $offset = 0);

    public function exec();

}