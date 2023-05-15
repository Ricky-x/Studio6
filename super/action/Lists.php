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
        $types = empty($_GET['types']) ? 'all' : $_GET['types'];

        $whereW = $whereT = '';
        if ($word != '') {
            $whereW = "name like '%{$word}%'";
        }
        if ($types != 'all') {
            $whereT = "types = '{$types}'";
        }
        if ($whereT != '' && $whereW != '') {
            $listDATA = $this->DB->getAll("select * from products where {$whereT} and {$whereW}");
        } else if ($whereT != '') {
            $listDATA = $this->DB->getAll("select * from products where {$whereT}");
        } else if ($whereW != '') {
            $listDATA = $this->DB->getAll("select * from products where {$whereW}");
        } else {
            $listDATA = $this->DB->getAll("select * from products");
        }

        return sendSuccess('get success', $listDATA);


    }
}


$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login = new Lists();
echo $login->$action();
