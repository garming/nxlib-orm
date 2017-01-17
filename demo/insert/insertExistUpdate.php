<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2017/1/4
 * Time: 18:06
 */

include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$table = "users";
$data = [
    'id' => 1,
    'name' => 'insertExistUpdate'
];
$update_data = [
    'name' => 'with-update-data',
    'created' => time()
];
//with update data
$result = $default->table($table)->insertExistUpdate($data,$update_data)->exec();
vd($result);

//just data
$data = [
    'id' => 1,
    'name' => 'just-data'
];
$result = $default->table($table)->insertExistUpdate($data)->exec();
vd($result);
