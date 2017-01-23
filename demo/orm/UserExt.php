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
    private $uid;
    private $nickname;

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }
}