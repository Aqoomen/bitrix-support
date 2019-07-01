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
        //echo $name;
        if (array_key_exists($name, $this->attributes))
        {
            return $this->attributes[$name];
        }
        else
        {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

}
