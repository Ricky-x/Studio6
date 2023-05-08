<?php

namespace action;

include_once 'Common.php';
include_once 'OPDBS.php';
include_once 'Base.php';
class Login extends \Base
{


    public function login()
    {

        $email  = $this->REQUEST['email'] ?? '';
        $passwd = $this->REQUEST['passwd'] ?? '';

        if ($email == '' || $passwd == '') {
            return sendSuccess('password account not written', [], 400);
        }

        $userData = $this->DB->getOne("select * from users where name = '{$email}' and password = '{$passwd}'" );
        if (empty($userData)) {
            return sendSuccess('password account not written', [], 400);
        }
        return sendSuccess('login successful', ['user_id' => $userData['id'], 'name' => $email]);
    }


    public function register()
    {
        $email  = $this->REQUEST['email'] ?? '';
        $passwd = $this->REQUEST['passwd'] ?? '';

        if ($email == '' || $passwd == '') {
            return sendSuccess('password account not written', [], 400);
        }
        $userData = $this->DB->getOne("select * from users where name = '{$email}'" );
        if ($userData) {
            return sendSuccess('Email account has been registered', [], 400);
        }

        $this->DB->insert('users', ['name' => $email, 'password' => $passwd]);
        $userData = $this->DB->getOne("select * from users where name = '{$email}'" );
        return sendSuccess('registration success', ['user_id' => $userData['id'], 'name' => $email]);

    }
}

$action = $_REQUEST['action'] ?? '';
if ($action == '') {
    echo sendSuccess('Can not be empty', [], 400);
    die;
}
$login  = new Login();
echo $login->$action();
