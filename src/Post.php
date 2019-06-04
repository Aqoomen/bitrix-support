<?php

namespace iPremium\Bitrix\Support;

class Post 
{
    public $attributes;

    public static $_instance;

    protected function __construct()
    {
        $this->attributes = $_POST;
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            static::$_instance = new static;
        }

        return static::$_instance;
        
    }

    public function all()
    {
        return $this->attributes;
    }

    public function __get($name)
    {
        //echo strtoupper($name);
        if (array_key_exists(strtoupper($name), $this->atributes))
        {
            return $this->atributes[strtoupper($name)];
        }
        else
        {
            return null;
        }
    }
    
    public function __set($name, $value)
    {
        $this->atributes[$name] = $value;
    }

}