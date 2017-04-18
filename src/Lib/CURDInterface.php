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

    public function query($sql,$bindParam = []);

    public function table($name, $alias = ''):CURDInterface;

    public function insert(array $data):CURDInterface;

    public function insertMulti(array $data):CURDInterface;

    public function insertExistUpdate(array $data, array $update_data):CURDInterface;

    public function update(array $data):CURDInterface;

    public function delete():CURDInterface;

    public function beginTransaction();

    public function commit();

    public function rollBack();

    public function select($fields = '*'):CURDInterface;

    public function selectOne($fields = '*'):CURDInterface;

    public function count():CURDInterface;

    public function where($column, $operation, $value):CURDInterface;

    public function orWhere($column, $operation, $value):CURDInterface;

    public function ljoin($tb, $alias, array $on):CURDInterface;

    public function rjoin($tb, $alias, array $on):CURDInterface;

    public function order($fields, $sort = "ASC"):CURDInterface;

    public function group($expression):CURDInterface;

    public function having($expression):CURDInterface;

    public function limit($limit = 1, $offset = 0):CURDInterface;

    public function exec();

    public function autoTransaction();

    public function autoRollBack();

    public function autoCommit();

}