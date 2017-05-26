<?php
namespace app\system;

use DB\SQL\Mapper;

class Closure extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'closure');
        $f3->set('title', 'Closure');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/closure.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $closure = new Mapper($this->db, 'closure');
        $closure->load(["data = ?", $data]);
        if ($closure->dry()) {
            $f3->log('Create closure ' . $data);
            $closure['data'] = strtoupper($data);
            $closure->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
