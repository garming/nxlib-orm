<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2016/3/22
 * Time: 11:11
 */

namespace NxLib\RdsOrm\Lib\Mysql;


class Instance
{
    public static function get($flag = "default")
    {
        return new CURD($flag);
    }
}