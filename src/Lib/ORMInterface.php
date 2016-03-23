<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 3/20/16
 * Time: 23:47
 */

namespace NxLib\RdsOrm\Lib;


interface ORMInterface
{
    public static function find();

    public static function findAll();

    public function save();

    public function delete();

}