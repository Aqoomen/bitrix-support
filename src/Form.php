<?php

namespace iPremium\Bitrix\Support;

use iPremium\Bitrix\Support\Post;

class Form
{
    public $fields;

    public $post;

    public $iblockId;

    public $toEmail;

    public $return;


    public function __construct($toEmail, Post $post, $iblockId = false)
    {
        if ($iblockId) {
            $this->iblockId = $iblockId;
        }

        $this->toEmail = $toEmail;
        $this->fields = $fields;

    }

    public function create($toEmail, $iblockId, $func)
    {
        $post = new Post();

        $form = new static($toEmail, $post, $iblockId);

        if (is_callable($func)) {
            return call_user_func($func, [
                $form
            ]);
        }

    }

    public function add($name, $text = '', $section_id = 0) 
    {
        if (\CModule::IncludeModule("iblock")) {

            $arElFields=array(
                    "IBLOCK_ID" => $this->iblockId, //Нужный ИБ
                    "IBLOCK_SECTION_ID" => $section_id, //Нужный раздел
                    "NAME" => $name, //Название элемента
                    "ACTIVE" => "N",
                    "PREVIEW_TEXT" => $text,
                    "PROPERTY_VALUES" => $this->fields,
                );

            $oElement = new \CIBlockElement();

            if($oElement->add($arElFields, false, false, false)){

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

    public function sendToEmail($event)
    {
        if (!empty($this->fields)) {
            return \CEvent::Send($event, SITE_ID, $this->fields);
        } else {
            return false;
        }

    }

    public function send($event)
    {
        if ($this->sendToEmail($event)) {

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
}