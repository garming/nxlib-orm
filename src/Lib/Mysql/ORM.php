<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 23:53
 */

namespace NxLib\RdsOrm\Lib\Mysql;


use NxLib\RdsOrm\Instance;
use NxLib\RdsOrm\Lib\Exception\ORMSaveException;
use NxLib\RdsOrm\Lib\ORMInterface;

class ORM implements ORMInterface
{
    protected static $table;
    protected static $connect = "default";
    protected static $primary = "id";
    protected static $clazzName;

    public static function find($primary_flag)
    {
        static::checkPrimary();
        $instance = Instance::get(static::$connect);
        $pk = static::$primary;
        $data = [];
        if(is_array($primary_flag) && is_string(array_keys($primary_flag)[0])){
            $find = $instance->table(static::getTable())->selectOne();
            foreach ($primary_flag as $key => $value){
                $find->where($key, "=", $value);
            }
            $data = $find->exec();
        }else{
            if (is_string($pk)) {
                $data = $instance->table(static::getTable())->selectOne()->where(static::$primary, "=", $primary_flag)->exec();
            } elseif (is_array($pk) && count($pk) == count($primary_flag)) {
                $first = current($pk);
                $find = $instance->table(static::getTable())->selectOne();
                if(isset($primary_flag[$first])){

                    foreach (static::$primary as $key){
                        $find->where($key, "=", $primary_flag[$key]);
                    }
                    $data = $find->exec();
                }else{
                    foreach (static::$primary as $key => $column){
                        $find->where($column, "=", $primary_flag[$key]);
                    }
                    $data = $find->exec();
                }
            }
        }
        if(empty($data)){
            return null;
        }
        $class = static::class;
        $obj = new $class();
        foreach ($obj as $key => $value) {
            if (isset($data[$key])) {
                $obj->$key = $data[$key];
            }
        }
        return $obj;
    }

    public static function findAll($condiction = [])
    {
        $instance = Instance::get(static::$connect);
        if(is_array($condiction) && is_string(array_keys($condiction)[0])){
            $find = $instance->table(static::getTable())->select();
            foreach ($condiction as $key => $value){
                $find->where($key, "=", $value);
            }
            $data = $find->exec();
        }
        $class = static::class;
        $list = [];
        foreach ($data as $row) {
            $obj = new $class();
            foreach ($obj as $key => $value) {
                if (isset($row[$key])) {
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
        static::checkPrimary();
        static::validate();
        $instance = Instance::get(static::$connect);
        $save = $instance->table(static::getTable());
        $pk = static::$primary;

        $save_data = [];
        foreach ($this as $key => $value) {
            $save_data[$key] = $value;
        }
        if (is_string($pk)) {
            if (!isset($save_data[$pk]) || empty($save_data[$pk])) {
                if (isset($save_data[$pk])) {
                    unset($save_data[$pk]);
                }
                $save = $save->insert($save_data)->exec();
                //insert
            } else {
                //update
                $save = $save->update($save_data)->where($pk, "=", $this->$pk)->exec();
            }
        } elseif (is_array($pk)) {
            foreach ($pk as $column) {
                if (!isset($save_data[$column])) {
                    throw new ORMSaveException('lost some primary key');
                }
            }
            $up_data = [];
            foreach ($save_data as $row => $row_value){
                if(!in_array($row,$pk)){
                    $up_data[$row] = $row_value;
                }
            }
            $save->insertExistUpdate($save_data,$up_data)->exec();
        }
        return $save;
    }

    public function delete($sham_del = [])
    {
        static::checkPrimary();
        $instance = Instance::get(static::$connect);
        $del = $instance->table(static::getTable());
        $pk = static::$primary;

        if (is_string($pk)) {
            if (!empty($sham_del)) {
                //logically deleted

                $del = $del->update($sham_del)->where($pk, "=", $this->$pk)->exec();
            } else {
                //physically deleted
                $del = $del->delete()->where($pk, "=", $this->$pk)->exec();
            }
        } elseif (is_array($pk)) {
            foreach ($pk as $column) {
                if (!isset($save_data[$column])) {
                    throw new ORMSaveException('lost some primary key');
                }
            }
            if (!empty($sham_del)) {
                //logically deleted
                $del->update($sham_del);
                foreach ($pk as $primary_key){
                    $del->where($primary_key,"=",$this->$primary_key);
                }

                $del = $del->exec();
            } else {
                //physically deleted
                $del->delete();
                foreach ($pk as $primary_key){
                    $del->where($primary_key,"=",$this->$primary_key);
                }
                $del = $del->exec();
            }
        }
        return $del;
    }
    private static function checkPrimary(){
        if(!is_string(static::$primary) && !is_array(static::$primary)){
            throw new ORMSaveException('$primary data type error,support `string` and `array` only');
        }
    }

    /**
     * validate data before save to db
     * if validate fail,throw ORMValidateException
     */
    public static function validate(){
    }
}
