<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 23:53
 */

namespace NxLib\RdsOrm\Lib\Mysql;


use NxLib\RdsOrm\Lib\ORMInterface;

class ORM implements ORMInterface
{
    protected $table;
    protected $connect = "default";

    public static function find()
    {
        //todo
    }

    public static function findAll()
    {
        //todo
    }

    public function save()
    {
        //todo
    }

    public function delete()
    {
        //todo
    }
}