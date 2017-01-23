<?php
namespace Demo;
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 24/01/2017
 * Time: 01:19
 */


use NxLib\RdsOrm\Instance;

include "../public.php";
include "User.php";
include "UserExt.php";
$config = include "../config.php";
Instance::init($config);

console(User::getTable());
console(UserExt::getTable());

//$list = User::findAll();
//vd($list);

$user = User::find(1);
vd($user);
$user->save();