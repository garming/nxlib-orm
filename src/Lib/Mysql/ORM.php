<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 23:53
 */

namespace NxLib\RdsOrm\Lib\Mysql;


use NxLib\RdsOrm\Instance;
use NxLib\RdsOrm\Lib\ORMInterface;

class ORM implements ORMInterface
{
    protected static $table;
    protected static $connect = "default";
    protected static $primary = "id";

    public static function find($primary_flag)
    {
        $instance = Instance::get(static::$connect);
        $data = $instance->table(static::$table)->selectOne()->where(static::$primary,"=",$primary_flag)->exec();
        $class = static::class;
        $obj = new $class();
        vd($obj);
        foreach ($data as $key => $value){
            $func = "set".ucfirst($key);
            call_user_func(array($obj, $func),$value);
        }
        return $obj;
    }

    public static function findAll($condiction = [])
    {
        $instance = Instance::get(static::$connect);
        $data = $instance->table(static::$table)->select()->exec();
        $class = static::class;
        $list = [];
        foreach ($data as $row){
            $obj = new $class();
            foreach ($row as $key => $value ){
                $func = "set".ucfirst($key);
                call_user_func(array($obj, $func),$value);
            }
            $list[] = $obj;
        }
        return $list;
    }

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return static::$table;
    }

    public function save()
    {
//        console(static::$primary);
//        console($this);
    }

    public function delete()
    {
        console($this);
    }
}