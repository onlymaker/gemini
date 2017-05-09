<?php
namespace app\system;

class Index extends SysBase
{
    function get($f3)
    {
        $f3->set('title', ' 系统配置');
        echo \Template::instance()->render('system/index.html');
    }
}
