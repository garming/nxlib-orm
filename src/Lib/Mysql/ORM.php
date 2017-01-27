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
        foreach ($obj as $key => $value){
            if(isset($data[$key])){
                $obj->$key = $data[$key];
            }
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
            foreach ($obj as $key => $value ){
                if(isset($row[$key])){
                    $obj->$key = $row[$key];
                }
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
        $instance = Instance::get(static::$connect);
        $save = $instance->table(static::$table);
        $pk = static::$primary;

        $save_data = [];
        foreach ($this as $key => $value){
            console($key ."=>".$value);
            $save_data[$key] = $value;
        }
        $save = $save->update($save_data)->where($pk,"=",$this->$pk)->exec();
        return $save;
    }

    public function delete($sham_del = [])
    {
        $instance = Instance::get(static::$connect);
        $del = $instance->table(static::$table);
        $pk = static::$primary;
        if(!empty($sham_del)){
            //logically deleted
            $del =  $del->update($sham_del)->where($pk,"=",$this->$pk)->exec();
        }else{
            //physically deleted
            $del =  $del->delete()->where($pk,"=",$this->$pk)->exec();
        }
        return $del;
    }
    public function add()
    {
        $instance = Instance::get(static::$connect);
        $save = $instance->table(static::$table);
        $pk = static::$primary;

        $save_data = [];
        foreach ($this as $key => $value){
            $save_data[$key] = $value;
        }
        if(is_null($this->$pk)){
            unset($save_data[$pk]);
        }
        $save = $save->insert($save_data)->exec();
        return $save;
    }
}
