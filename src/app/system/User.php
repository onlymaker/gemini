<?php
namespace app\system;

use DB\SQL\Mapper;

class User extends SysBase
{
    function get($f3)
    {
        $user = new Mapper($this->db, 'user');
        $users = $user->find();
        $f3->set('title', '  用户管理');
        $f3->set('users', $users);
        echo \Template::instance()->render('system/user.html');
    }

    function create($f3)
    {
        $name = $_POST['name'];
        $user = new Mapper($this->db, 'user');
        $user->load(["username = ?", $name]);
        if ($user->dry()) {
            $f3->log('Create user ' . $name);
            $user['username'] = $name;
            $user['salt'] = bin2hex(random_bytes(4));
            $user['password'] = md5(md5('123456') . $user['salt']);
            $user->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }

    function resetPassword($f3)
    {
        $id = $_POST['id'];
        $user = new Mapper($this->db, 'user');
        $user->load(["id = ?", $id]);
        if (!$user->dry()) {
            $f3->log('Reset password for user ' . $user['username']);
            $user['salt'] = bin2hex(random_bytes(4));
            $user['password'] = md5(md5('123456') . $user['salt']);
            $user->save();
        }
        echo 'SUCCESS';
    }
}
