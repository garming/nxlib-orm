<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 05/12/2016
 * Time: 01:33
 */
include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$sql = "
CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '用户名',
	`created` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `name` (`name`)
)
COMMENT='用户表'
ENGINE=InnoDB
;
";
try{
    $result = $default->query($sql);
    vd($result);
}catch (Exception $e){
    $e->getTrace();
}
