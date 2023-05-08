<?php

namespace action;

include_once 'Base.php';

class Detail extends \Base
{
    public function getOneDetail()
    {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $oneDetail = $this->DB->getOne('select * from products as p left join products_price as pp on pp.product_id = p.id
            where p.id = ' . $id);
            if ($oneDetail) {
                return sendSuccess('get success', $oneDetail);
            }
        }
        return sendSuccess('Product does not exist', [], 400);

    }

}


$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login  = new Detail();
echo $login->$action();