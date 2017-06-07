<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 11/20/15
 * Time: 10:21
 */

namespace NxLib\RdsOrm\Lib;


class EmpFunc implements CURDInterface
{
    public function __call($name, $arguments)
    {
        return null;
    }

    public function query($sql, $bindParam = [])
    {
        // TODO: Implement query() method.
    }

    public function table($name, $alias = ''): CURDInterface
    {
        // TODO: Implement table() method.
    }

    public function insert(array $data): CURDInterface
    {
        // TODO: Implement insert() method.
    }

    public function insertMulti(array $data): CURDInterface
    {
        // TODO: Implement insertMulti() method.
    }

    public function insertExistUpdate(array $data, array $update_data): CURDInterface
    {
        // TODO: Implement insertExistUpdate() method.
    }

    public function update(array $data): CURDInterface
    {
        // TODO: Implement update() method.
    }

    public function delete(): CURDInterface
    {
        // TODO: Implement delete() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }

    public function rollBack()
    {
        // TODO: Implement rollBack() method.
    }

    public function select($fields = '*'): CURDInterface
    {
        // TODO: Implement select() method.
    }

    public function selectOne($fields = '*'): CURDInterface
    {
        // TODO: Implement selectOne() method.
    }

    public function count(): CURDInterface
    {
        // TODO: Implement count() method.
    }

    public function where($column, $operation, $value): CURDInterface
    {
        // TODO: Implement where() method.
    }

    public function orWhere($column, $operation, $value): CURDInterface
    {
        // TODO: Implement orWhere() method.
    }

    public function ljoin($tb, $alias, array $on): CURDInterface
    {
        // TODO: Implement ljoin() method.
    }

    public function rjoin($tb, $alias, array $on): CURDInterface
    {
        // TODO: Implement rjoin() method.
    }

    public function order($fields, $sort = "ASC"): CURDInterface
    {
        // TODO: Implement order() method.
    }

    public function group($expression): CURDInterface
    {
        // TODO: Implement group() method.
    }

    public function having($expression): CURDInterface
    {
        // TODO: Implement having() method.
    }

    public function limit($limit = 1, $offset = 0): CURDInterface
    {
        // TODO: Implement limit() method.
    }

    public function exec()
    {
        // TODO: Implement exec() method.
    }

    public function autoTransaction()
    {
        // TODO: Implement autoTransaction() method.
    }

    public function autoRollBack()
    {
        // TODO: Implement autoRollBack() method.
    }

    public function autoCommit()
    {
        // TODO: Implement autoCommit() method.
    }
}