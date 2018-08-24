<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2017/1/4
 * Time: 18:05
 */
include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$table = "users";
//$data = $default->table($table)->select()->exec();
//console($data);

//$data = $default->table($table)->select()->where("id","=",1)->exec();
//console($data);
//
//$data = $default->table($table)->select()->where("id",">",1)->exec();
//console($data);
//
//$data = $default->table($table)->select()->where("id","<",1)->exec();
//console($data);
//
$user = $default->table($table)->select();
$count = $default->table($table)->count();
$arr = [$user,$count];
foreach ( $arr as $obj){
    $data = $obj->where("id"," = ","1")->exec();
    console($data);
}