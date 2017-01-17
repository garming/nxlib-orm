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
$time = time();
$data = [
    [
        'name' => 'name'.$time,
        'created' => $time
    ],
    [
        'name' => 'name'.strval($time+1),
        'created' => $time+1
    ],
    [
        'name' => 'name'.strval($time+2),
        'created' => $time+2
    ],
    [
        'name' => 'name'.strval($time+3),
        'created' => $time+3
    ],
];
$result = $default->table($table)->insertMulti($data)->exec();
vd($result);
