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
$sql = "select * from users";
$data = $default->query($sql);

$sql = "select * from users where id=?";
$data = $default->query($sql,[1]);

