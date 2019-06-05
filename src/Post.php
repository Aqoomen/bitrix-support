<?php

namespace iPremium\Bitrix\Support;

class Post 
{
    public $attributes;

    protected function __construct($post)
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