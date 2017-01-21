<?php
/**
 * use raw sql to do this
 */

include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

//add column
$sql ="ALTER TABLE `users`
	ADD COLUMN `modified` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间' AFTER `created`;";
vd($default->query($sql));

//edit column
$sql ="ALTER TABLE `users`
	CHANGE COLUMN `created` `created` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间' AFTER `name`;";
vd($default->query($sql));

