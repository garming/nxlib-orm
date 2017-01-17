<?php
/**
 * use raw sql to do this
 */

include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$sql = "
    CREATE TABLE `users` (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '用户名',
        `created` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
        PRIMARY KEY (`id`),
        INDEX `name` (`name`)
    )
    COMMENT='用户表'
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB;
";

vd($default->query($sql));

$sql = "
    CREATE TABLE `user_ext` (
        `uid` INT(10) UNSIGNED NOT NULL DEFAULT '0',
        `nickname` VARCHAR(50) NOT NULL DEFAULT '',
        PRIMARY KEY (`uid`)
    )
    COMMENT='用户扩展表'
    ENGINE=InnoDB;
";

vd($default->query($sql));
