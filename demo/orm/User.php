<?php
namespace Demo;
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 24/01/2017
 * Time: 01:17
 */
class User extends \NxLib\RdsOrm\Lib\Mysql\ORM
{
    protected static $table = "users";
    public $id;
    public $name;
    public $created;
    public $modified;
}