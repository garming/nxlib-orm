<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2017/6/7
 * Time: 20:08
 */

namespace NxLib\RdsOrm\Lib;


use NxLib\RdsOrm\Instance;

class DB
{
    /**
     * @var CURDInterface $instance;
     */
    private static $instance = null;

    public static function instance($flag = 'default'):CURDInterface
    {
        return Instance::get($flag);
    }
    public static function query($sql,$bindParam = [])
    {
        return static::getInstance()->query($sql,$bindParam);
    }

    public static function table($name, $alias = ''):CURDInterface
    {
        return static::getInstance()->table($name,$alias);
    }

    public static function insert(array $data):CURDInterface
    {
        return static::getInstance()->insert($data);
    }

    public static function insertMulti(array $data):CURDInterface
    {
        return static::getInstance()->insertMulti($data);
    }

    public static function insertExistUpdate(array $data, array $update_data):CURDInterface
    {
        return static::getInstance()->insertExistUpdate($data);
    }

    public static function update(array $data):CURDInterface
    {
        return static::getInstance()->update($data);
    }

    public static function delete():CURDInterface
    {
        return static::getInstance()->delete();
    }

    public static function beginTransaction()
    {
        static::getInstance()->beginTransaction();
    }

    public static function commit()
    {
        static::getInstance()->commit();
    }

    public static function rollBack()
    {
        static::getInstance()->rollBack();
    }

    public static function select($fields = '*'):CURDInterface
    {
        return static::getInstance()->select($fields);
    }

    public static function selectOne($fields = '*'):CURDInterface
    {
        return static::getInstance()->selectOne($fields);
    }

    public static function count():CURDInterface
    {
        return static::getInstance()->count();
    }

    public static function where($column, $operation, $value):CURDInterface
    {
        return static::getInstance()->where($column, $operation, $value);
    }

    public static function orWhere($column, $operation, $value):CURDInterface
    {
        return static::getInstance()->orWhere($column, $operation, $value);
    }

    public static function ljoin($tb, $alias, array $on):CURDInterface
    {
        return static::getInstance()->ljoin($tb, $alias, $on);
    }

    public static function rjoin($tb, $alias, array $on):CURDInterface
    {
        return static::getInstance()->rjoin($tb, $alias, $on);
    }

    public static function order($fields, $sort = "ASC"):CURDInterface
    {
        return static::getInstance()->order($fields, $sort);
    }

    public static function group($expression):CURDInterface
    {
        return static::getInstance()->group($expression);
    }

    public static function having($expression):CURDInterface
    {
        return static::getInstance()->having($expression);
    }

    public static function limit($limit = 1, $offset = 0):CURDInterface
    {
        return static::getInstance()->limit($limit, $offset);
    }

    public static function exec()
    {
        return static::getInstance()->exec();
    }

    public static function autoTransaction()
    {
        static::getInstance()->autoTransaction();
    }

    public static function autoRollBack()
    {
        static::getInstance()->autoRollBack();
    }

    public static function autoCommit()
    {
        static::getInstance()->autoCommit();
    }

    private static function getInstance():CURDInterface
    {
        if(is_null(static::$instance)){
            static::$instance = static::instance();
        }
        return static::$instance;
    }
}