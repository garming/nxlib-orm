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
$time = time();
$name = "name_".rand($time,$time+10);
$rs = $default->query("INSERT INTO test (`name`, `created`) VALUES ('{$name}', $time);");
var_dump($rs);
$rs = $default->query("select * from test where id=?",[1]);
var_dump($rs);
$select = $default->table("test")->insert(['name' => 'ins_'.$name,'created' => $time+1])->exec();
var_dump($select);
//update
$default->table("test")->update(['name' => "name_2_update_".rand(100,999)])->where("id","=",2)->exec();
//delete
$default->table("test")->delete()->where("id","=",rand(3,6))->exec();
//select
$select = $default->table("test")->select()->exec();
pr($select);
//$select = $default->table("test")->select()->where("id","=",1)->exec();
//pr($select);
$select = $default->table("test")->select()->where("created","=",111111)->where("id","=",77)
    ->orWhere("id","=",1)
    ->exec();
pr($select);
$select = $default->table("test",'u')
    ->select()
    ->where("created","=",111111)
    ->orWhere("id","=",1)
    ->group("created")
    ->order("id","DESC")
    ->exec();
pr($select);
//$select = $default->table("test",'u')
//    ->select(['u.id','t.name','u.created'])
//    ->ljoin("tid",'t',['u.id','t.id'])
//    ->where("u.created","=",111111)
//    ->orWhere("u.id","=",1)
//    ->group("u.created")
//    ->order("u.id","ASC")
//    ->exec();
//pr($select);