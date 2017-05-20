<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;

class Edit extends AppBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_GET['id']]);
        if ($mapper->dry()) {
            header('HTTP/1.1 404 Not Found');
        } else {
            $f3->set('title', 'Edit');
            $f3->set('raw', $mapper);
            echo \Template::instance()->render('edit.html');
        }
    }
}
