<?php
include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$sql = "
ALTER TABLE `users`
	CHANGE COLUMN `created` `created` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间' AFTER `name`;
";

try{
    $result = $default->query($sql)->exec();
    vd($result);
}catch (Exception $e){
    $e->getTrace();
}
