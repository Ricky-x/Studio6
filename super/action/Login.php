<?php

namespace action;

include_once 'Common.php';
include_once 'OPDBS.php';
include_once 'Base.php';

class Login extends \Base
{


    public function login()
    {

        $name = $this->REQUEST['email'] ?? '';
        $passwd = $this->REQUEST['passwd'] ?? '';

        if ($name == '' || $passwd == '') {
            return sendSuccess('password account not written', [], 400);
        }

        $userData = $this->DB->getOne("select * from users where name = '{$name}' and password = '{$passwd}'");
        if (empty($userData)) {
            return sendSuccess('password account not written', [], 400);
        }
        return sendSuccess('login successful', ['user_id' => $userData['id'], 'name' => $name]);
    }


    public function register()
    {
        $name = $this->REQUEST['name'] ?? '';
        $email = $this->REQUEST['email'] ?? '';
        $phone = $this->REQUEST['phone'] ?? '';
        $passwd = $this->REQUEST['passwd'] ?? '';

        if ($email == '' || $passwd == '' || $name == '' || $phone == '') {
            return sendSuccess('password account not written', [], 400);
        }
        $userData = $this->DB->getOne("select * from users where name = '{$name}'");
        if ($userData) {
            return sendSuccess('name account has been registered', [], 400);
        }
        $userData = $this->DB->getOne("select * from users where email = '{$email}'");
        if ($userData) {
            return sendSuccess('email account has been registered', [], 400);
        }

        $data = ['name' => $name, 'password' => $passwd, 'phone' => $phone, 'email' => $email];
        $this->DB->insert('users', $data);
        $userData = $this->DB->getOne("select * from users where name = '{$name}'");
        return sendSuccess('registration success', ['user_id' => $userData['id'], 'name' => $name]);

    }
}

$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login = new Login();
echo $login->$action();
