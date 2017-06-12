<?php
namespace app;

use app\common\Url;

class Logout
{
    use Url;

    function get($f3)
    {
        $f3->clear('SESSION.AUTHENTICATION');
        $f3->clear('SESSION.AUTHORIZATION');
        header('location:' . $this->url($f3->get('BASE')));
    }
}
