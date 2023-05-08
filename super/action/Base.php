<?php

include_once 'Common.php';
include_once 'OPDBS.php';
class Base
{

    public $DB = null;
    public $REQUEST;

    public function __construct()
    {
        $this->DB = new \OPDBS();
        $this->REQUEST = json_decode(file_get_contents( "php://input"),1);
    }


    function isLogin()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $userId = $this->REQUEST['user_id'] ?? 0;
        } else {
            $userId = $_GET['user_id'] ?? 0;

        }
        return $this->DB->getOne('select * from users where id = ' . $userId);
    }
}