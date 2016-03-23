<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 12:41
 */

namespace NxLib\RdsOrm\Lib;


interface ConnectInterface
{
    public static function getConnection($connection_flag = 'default');

    public static function connectdb($connection_flag = 'default', array $connect_config);

    public static function close($connection_flag = 'default');
}