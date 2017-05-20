<?php
namespace app;

use app\common\AppBase;

class Password extends AppBase
{
    function get($f3)
    {
        $f3->set('title', '修改密码');
        echo \Template::instance()->render('password.html');
    }

    function post($f3)
    {
        $username = $this->user['name'];
        $password = $_POST['oldPassword'];
        $query = $this->db->exec("SELECT * FROM user WHERE username = '$username' AND PASSWORD = md5(concat('$password', salt))");
        if ($query) {
            $salt = bin2hex(random_bytes(4));
            $password = md5($_POST['newPassword'] . $salt);
            $this->db->exec('UPDATE user SET salt = ?, password = ? WHERE username = ?', [$salt, $password, $username]);
            $this->error['code'] = 0;
        } else {
            $this->error['text'] = '认证失败';
        }
        echo $this->jsonResponse();
    }
}
