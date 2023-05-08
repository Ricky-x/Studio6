<?php

namespace action;

include_once 'Base.php';

class Cart extends \Base
{

    public function delCart()
    {
        $userData = $this->isLogin();
        if (!$userData) {
            return sendSuccess('please log in first', [], 400);
        }

        $id = $this->REQUEST['id'];
        $this->DB->query('delete from cart where id = ' . $id);
        return sendSuccess('successfully deleted');

    }

    public function getAll()
    {
        $userData = $this->isLogin();
        if (!$userData) {
            return sendSuccess('please log in first', [], 400);
        }
        $cartData = $this->DB->getAll('select * from cart where user_id = ' . $userData['id']);

        $aa = $this->DB->getAll('select * from supermarkets');

        $superData = [];
        foreach ($aa as $item) {
            $superData[$item['id']] = $item['name'];
        }

        $data = [];
        foreach ($cartData as $datum) {
            $data[$datum['id']]['data'] = $this->DB->getAll('select * from products as p left join products_price as pp 
        on pp.product_id = p.id where p.id = ' . $datum['product_id']);
            $data[$datum['id']]['count'] = $datum['count'];
        }
        $dataa = [];
        foreach ($data as $key => $datums) {
            foreach ($datums['data'] as $datumdd) {
                $dataa[$key]['name'] = $datumdd['name'];
                $dataa[$key]['cover'] = $datumdd['cover'];
                $dataa[$key]['remark'] = $datumdd['remark'];
                $dataa[$key]['name'] = $datumdd['name'];

                $dataa[$key]['supermarket'][] = [
                    'name' => $superData[$datumdd['supermarket_id']],
                    'price' => $datumdd['price'],
                    'count' => $datums['count'],
                ];
            }
        }

        return sendSuccess('success', $dataa);
    }

    public function addCart()
    {
        $userData = $this->isLogin();
        if (!$userData) {
            return sendSuccess('please log in first', [], 400);
        }
        $productId = $this->REQUEST['id'] ?? 0;
        $productData = $this->DB->getOne('select * from products as p left join products_price as pp 
        on pp.product_id = p.id where p.id = ' . $productId);
        if (empty($productData)) {
            return sendSuccess('Product does not exist', [], 400);
        }
        $this->DB->insert('cart', ['order_no' => uniqid(), 'product_id' => $productId,
            'user_id' => $userData['id'], 'create_at' => date('Y-m-d H:i:s')]);

        return sendSuccess('success');
    }

    public function countU()
    {
        $userData = $this->isLogin();
        if (!$userData) {
            return sendSuccess('please log in first', [], 400);
        }
        $cartId = $this->REQUEST['id'] ?? 0;
        $act = $_REQUEST['act'] ?? 1;
        $productData = $this->DB->getOne('select * from cart where id = ' . $cartId);

        if ($act == 1) {
            $count = $productData['count'] + 1;
        } else {
            $count = $productData['count'] - 1;
        }
        $this->DB->query('update cart set count = ' . $count . ' where id = ' . $cartId);

        return sendSuccess('success');

    }
}


$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('parameter cannot be empty', [], 400);
    die;
}
$login = new Cart();
echo $login->$action();