<?php
namespace iPremium\Bitrix\Support;

class Bot
{
    public static function id()
    {
        return session_id();
    }

    public static function salt()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public static function get()
    {
        return md5(self::id() . self::salt());
    }

    public static function check($string)
    {
        return ($string == self::get());
    }

    public static function checkThen($post, $func)
    {
        if (self::check($post['_token'])) {
            call_user_func_array($func, array($post));
        }
    }
}
