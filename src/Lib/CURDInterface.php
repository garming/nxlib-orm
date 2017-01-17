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

    public function table($name, $alias = '');

    public function insert(array $data);

    public function insertMulti(array $data);

    public function insertExistUpdate(array $data, array $update_data);

    public function update(array $data);

    public function delete();

    public function beginTransaction();

    public function commit();

    public function rollBack();

    public function select($fields = '*');

    public function selectOne($fields = '*');

    public function count();

    public function where($column, $operation, $value);

    public function orWhere($column, $operation, $value);

    public function ljoin($tb, $alias, array $on);

    public function rjoin($tb, $alias, array $on);

    public function order($fields, $sort = "ASC");

    public function group($expression);

    public function having($expression);

    public function limit($limit = 1, $offset = 0);

    public function exec();

    public function autoTransaction();

    public function autoRollBack();

    public function autoCommit();

}