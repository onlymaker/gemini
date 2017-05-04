<?php
namespace app;

use app\common\Url;
use Ramsey\Uuid\Uuid;

class Login
{
    use Url;

    function get()
    {
        echo \Template::instance()->render('login.html');
    }

    function post($f3)
    {
        $auth = [
            'username' => 'onlymaker',
            'password' => md5('onlymaker123')
        ];

        $f3->log('user login: ' . $_POST['username']);

        if ($auth['username'] === $_POST['username'] && $auth['password'] === $_POST['password']) {
            $uuid = str_replace('-', '', Uuid::uuid1());
            $f3->set('SESSION.AUTH', $uuid);
            echo json_encode([
                'error' => ['code' => 0]
            ]);
        } else {
            echo json_encode([
                'error' => [
                    'code' => -1,
                    'text' => 'login error'
                ]
            ]);
        }
    }
}
