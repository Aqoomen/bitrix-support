<?php

namespace Aqoomen\Bitrix\Support;

class Post 
{
    public $attributes;

    public function __construct($post)
    {
        $this->attributes = $post;
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
            return $this->atributes[$name];
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