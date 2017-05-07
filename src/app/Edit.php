<?php
namespace app;

use app\common\AppBase;

class Edit extends AppBase
{
    function get($f3)
    {
        $f3->set('title', '  Edit');
        echo \Template::instance()->render('edit.html');
    }
}
