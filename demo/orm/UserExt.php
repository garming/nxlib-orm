<?php
namespace Demo;
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 24/01/2017
 * Time: 01:18
 */
class UserExt extends \NxLib\RdsOrm\Lib\Mysql\ORM
{
    protected static $table = "user_ext";
    protected static $primary = "uid";
    public $uid;
    public $nickname;
}