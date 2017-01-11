<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 2017/1/4
 * Time: 17:11
 */
return [
    'default' => [//default must exist
        'driver' => 'mysql',
        'hostname' => '127.0.0.1',
        'port' => '3306',
        'username' => 'root',
        'password' => 'root',
        'database' => 'test_db_1',
        'charset' => 'utf8'
    ],
    'no_def' => [// if you have tow more different db,you can add like this
        'driver' => 'mysql',
        'hostname' => '127.0.0.1',
        'port' => '3306',
        'username' => 'root',
        'password' => '',
        'database' => 'test_db_2',
        'charset' => 'utf8'
    ]
];