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
