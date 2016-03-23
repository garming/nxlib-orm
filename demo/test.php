<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2016/3/21
 * Time: 19:18
 */

function pr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

require '../vendor/autoload.php';

$config = require_once "config.php";

$init = \NxLib\RdsOrm\Instance::init($config);

$default = \NxLib\RdsOrm\Instance::get();
//$rs = $default->query("INSERT INTO `testdb`.`user` (`id`, `name`, `created`) VALUES (4, '999', 8888);");
//$rs = $default->query("INSERT INTO `testdb`.`tid` (`name`) VALUES ('999');");
//var_dump($rs);
//$rs = $default->query("select * from user where id=?",[3]);
//var_dump($rs);
//$select = $default->table("user")->insert(['id' => 77,'name' => 'xxxxxx','created' => 111111])->exec();
//$select = $default->table("tid")->insert(['name' => 'xxxxxx'])->exec();
//var_dump($select);
//update
//$default->table("user")->update(['name' => "xxxx"])->where("id","=",2)->exec();
//delete
//$default->table("user")->delete()->where("id","=",2)->exec();
//select
//$select = $default->table("user")->select()->exec();
//pr($select);
//$select = $default->table("user")->select()->where("id","=",1)->exec();
//pr($select);
//$select = $default->table("user")->select()->where("created","=",111111)->where("id","=",77)
//    ->orWhere("id","=",1)
//    ->exec();
//pr($select);
//$select = $default->table("user",'u')
//    ->select()
//    ->where("created","=",111111)
//    ->orWhere("id","=",1)
//    ->group("created")
//    ->order("id","DESC")
//    ->exec();
//pr($select);
//$select = $default->table("user",'u')
//    ->select(['u.id','t.name','u.created'])
//    ->ljoin("tid",'t',['u.id','t.id'])
//    ->where("u.created","=",111111)
//    ->orWhere("u.id","=",1)
//    ->group("u.created")
//    ->order("u.id","ASC")
//    ->exec();
//pr($select);