<?php
namespace app;

use app\common\Url;
use Ramsey\Uuid\Uuid;

class Login
{
    use Url;

    function get($f3)
    {
        $f3->set('title', '登录');
        echo \Template::instance()->render('login.html');
    }

    function post($f3)
    {
        $auth = [
            'username' => 'onlymaker',
            'password' => md5('onlymaker123')
        ];

        $f3->log('user login: ' . $_POST['username']);

        if ($this->authenticate($_POST['username'], $_POST['password'])) {
            $uuid = str_replace('-', '', Uuid::uuid1());
            $f3->set('SESSION.AUTHENTICATION', $uuid);
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

    function authenticate($username, $password)
    {
        $users = [
            [
                'username' => 'onlymaker',
                'password' => md5('onlymaker123')
            ],
            [
                'username' => 'debug',
                'password' => md5('123456')
            ]
        ];
        foreach ($users as $user) {
            if ($username === $user['username'] && $password === $user['password']) {
                return true;
            }
        }
        return false;
    }
}
