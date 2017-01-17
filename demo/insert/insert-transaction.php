<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2017/1/4
 * Time: 18:06
 */

include "../public.php";
$config = include "../config.php";
$init = \NxLib\RdsOrm\Instance::init($config);
$default = \NxLib\RdsOrm\Lib\Mysql\Instance::get();

$table = "users";
$data = [
    'name' => 'name'.time(),
    'created' => time()
];
try{
    $default->autoTransaction();
    //code
    $uid = $default->table($table)->insert($data)->exec();
    vd($uid);

    $ext_data = [
        'uid' => $uid,
        'nickname' => 'nickname-'.$uid,
    ];
    $result = $default->table('user_ext')->insert($ext_data)->exec();
    vd($result);

    $default->autoCommit();
}catch (\Exception $e){
    $default->autoRollBack();
    console($e->getMessage());
}

