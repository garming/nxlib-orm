<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2016/3/21
 * Time: 19:18
 */

function pr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

require '../vendor/autoload.php';

$config = require_once "config.php";

class Entity extends \NxLib\RdsOrm\Lib\Mysql\ORM {
    public $id;
    public $name;
    public $time;
}
$data = [
  "id" => 1,
  "name" => 2
];
$entity = new Entity($data);
pr($entity);
