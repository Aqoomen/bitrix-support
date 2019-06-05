<?php

namespace Aqoomen\Bitrix\Support;

use Aqoomen\Bitrix\Support\Post;

class Form
{
    protected $fields;

    protected $post;

    protected $iblock;

    protected $return;

    protected $email;

    protected $detail;

    protected $preview;

    protected $name;

    protected $event;


    public function __construct($post)
    {
        $this->post(new Post($post));
    }

    public function to($email = null)
    {
        if (!is_null($email))
        {
            $this->email = $email;
        }

        return $this->email;
 
    }

    public function post($post = null)
    {
        if (!is_null($post))
        {
            $this->post = $post;
        }

        return $this->post;
    }

    public function iblock($iblock = null)
    {
        if (!is_null($iblock))
        {
            $this->iblock = $iblock;
        }

        return $this->iblock;
    }

    public function event($event = null)
    {
        if (!is_null($event))
        {
            $this->event = $event;
        }

        return $this->event;
    }

    public function create(Post $post, $func)
    {
        $form = new static();

        if (is_callable($func)) {
            return call_user_func($func, [
                $form
            ]);
        }

    }

    public function mame($name = null)
    {
        if (!is_null($name))
        {
            $this->name = $name;
        }

        return $this->name;
    }

    public function text($text, $flag = 'D')
    {
        switch($flag) {
            case 'D':
                $this->detail = $text;
                break;
            case 'P':
                $this->preview = $text;
                break;
        }
    }

    protected function prepareFields($params)
    {
        foreach ($params as &$param) {
            $param = strtoupper($param);
        }

        return $params;
    }

    protected function element($sectionId = 0)
    {
        return $fields = [
            "IBLOCK_ID" => $this->iblock, //Нужный ИБ
            "IBLOCK_SECTION_ID" => $sectionId, //Нужный раздел
            "NAME" => $this->name, //Название элемента
            "ACTIVE" => "N",
            "PROPERTY_VALUES" => prepareFields($this->fields),
        ];

    }

    public function add($sectionId = 0) 
    {
        if (\CModule::IncludeModule("iblock")) {

            $oElement = new \CIBlockElement();

            if($oElement->add($this->element(), false, false, false)){

                $this->return = ["error" => false];

                array_push($this->return["list"], ["message" => "add() ok", "code" => 1 ]);

                return $this;

                } else {

                $this->return = ["error" => true];

                array_push($this->return["list"], ["message" => "add() error", "code" => 300 ]);

                return $this;
            }

        }
    }

    public function setFileds($fields = [])
    {
        $this->fields = $fields; 
    }

    public function getFileds()
    {
        return $this->fields;
    }



    public function sendToEmail()
    {
        if (!empty($this->fields)) {
            return \CEvent::Send($this->event, SITE_ID, $this->fields);
        } else {
            return false;
        }

    }

    public function send()
    {
        if ($this->sendToEmail()) {

            $this->return = ["error" => false];

            array_push($this->return["list"], ["message" => "send() ok", "code" => 1 ]);

            return $this;

        } else {

            $this->return = ["error" => true];

            array_push($this->return["list"], ["message" => "send() error", "code" => 200 ]);

            return $this;
        }
    }

    public function result()
    {
        return $this->return;
    }

    public function json()
    {
        return json_encode($this->return);
    }

    public function __get($name)
    {
        //echo strtoupper($name);
        if (array_key_exists(strtoupper($name), $this->fields))
        {
            return $this->fields[strtoupper($name)];
        }
        else
        {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $this->fields[strtoupper($name)] = $value;
    }

}