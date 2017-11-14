<?php
/**
 * Created by PhpStorm.
 * User: garming
 * Date: 11/19/15
 * Time: 23:01
 */

namespace NxLib\RdsOrm\Lib\Mysql;


use NxLib\RdsOrm\Lib\ConnectInterface;

class Connect implements ConnectInterface
{
    private static $all_connection = [];
    private static $config = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

  /**
   * @param string $connection_flag
   *
   * @return \PDO
   */
    public static function getConnection($connection_flag = 'default')
    {
        if (isset(self::$all_connection[$connection_flag])) {
            return self::$all_connection[$connection_flag];
        }
        return null;
    }

    public static function connectdb($connection_flag = 'default', array $config)
    {
        self::$config[$connection_flag] = $config;
        if (empty($connection_flag)) {
          return;
        }
        if (!isset($config['driver']) || $config['driver'] != 'mysql') {
          return;
        }
        if (isset(self::$all_connection[$connection_flag])) {
          return;
        }
        $dsn = "mysql:dbname={$config['database']};host={$config['hostname']};port={$config['port']}";
        $pdo = new \PDO(
            $dsn,
            $config['username'],
            $config['password'],
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}")
        );
        $pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, isset($config['ATTR_EMULATE_PREPARES']) ? $config['ATTR_EMULATE_PREPARES']:false);
        self::$all_connection[$connection_flag] = $pdo;
    }

    public static function close($connection_flag = 'default')
    {
        if (isset(self::$all_connection[$connection_flag])) {
            unset(self::$all_connection[$connection_flag]);
        }
    }
  public static function reConnect($connection_flag = 'default')
  {
    $config = self::$config[$connection_flag];
    $dsn = "mysql:dbname={$config['database']};host={$config['hostname']};port={$config['port']}";
    $pdo = new \PDO(
      $dsn,
      $config['username'],
      $config['password'],
      array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}")
    );
    $pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, isset($config['ATTR_EMULATE_PREPARES']) ? $config['ATTR_EMULATE_PREPARES']:false);
    self::$all_connection[$connection_flag] = $pdo;
  }
}
