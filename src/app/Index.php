<?php
namespace app;

use app\common\AppBase;

class Index extends AppBase
{
    function get($f3)
    {
        echo $f3->get('REALM');
    }
}
