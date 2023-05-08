<?php

namespace action;


include_once 'Common.php';
include_once 'OPDBS.php';
include_once 'Base.php';

class Home extends \Base
{
    public function Boutique()
    {

        $productsArr = $this->DB->getAll('select * from products where hot = 1');

        return sendSuccess('get success', $productsArr);
    }

}


$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login  = new Home();
echo $login->$action();