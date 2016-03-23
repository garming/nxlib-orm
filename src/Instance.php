<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 11/19/15
 * Time: 23:02
 */

namespace NxLib\RdsOrm;


use NxLib\RdsOrm\Lib\EmpFunc;

class Instance
{
    private static $flag = [];

    private function __construct()
    {
    }

    public function __clone()
    {
    }

    public static function init($config)
    {
        if (!isset($config['default']) || empty($config['default'])) {
            return;
        }
        foreach ($config as $k => $v) {
            $driver = ucfirst($v['driver']);
            $className = __NAMESPACE__ . '\\Lib\\' . $driver . "\\Connect";
            if (class_exists($className)) {
                self::$flag[$k] = $driver;
                $className::connectdb($k, $v);
            }
        }
    }

    public static function get($flag = 'default')
    {
        if (!isset(self::$flag[$flag])) {
            return (new EmpFunc());
        }
        $className = __NAMESPACE__ . '\\Lib\\' . self::$flag[$flag] . "\\Instance";
        return ($className::get($flag));
    }
}