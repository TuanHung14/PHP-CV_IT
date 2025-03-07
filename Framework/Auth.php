<?php
 namespace Framework;


class Auth
{
    protected static $user = null;
    
    public static function setUser($user)
    {
        self::$user = $user;
    }

    // Lấy user hiện tại
    public static function user()
    {
        return self::$user;
    }

    // Kiểm tra user đã đăng nhập chưa
    public static function check()
    {
        return self::$user !== null;
    }
}