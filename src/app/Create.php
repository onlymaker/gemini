<?php
namespace app;

use app\common\AppBase;

class Create extends AppBase
{
    function get($f3)
    {
        $f3->set('title', '  Create');
        echo \Template::instance()->render('create.html');
    }
}
