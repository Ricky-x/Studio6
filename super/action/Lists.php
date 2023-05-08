<?php

namespace action;

include_once 'Base.php';

class Lists extends \Base
{
    public function getAll()
    {
        $listDATA = $this->DB->getAll('select * from products');
        return sendSuccess('get success', $listDATA);
    }

    public function seacher()
    {
        $word = $_GET['word'] ?? '';
        if ($word != '') {
            $listDATA = $this->DB->getAll("select * from products where name like '%{$word}%'");
            return sendSuccess('get success', $listDATA);
        }
        return sendSuccess('Please enter a keyword', [], 400);

    }
}


$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login  = new Lists();
echo $login->$action();
