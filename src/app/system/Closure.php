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
        $name = $_POST['name'];
        $closure = new Mapper($this->db, 'closure');
        $closure->load(["name = ?", $name]);
        if ($closure->dry()) {
            $f3->log('Create closure ' . $name);
            $closure['name'] = strtoupper($name);
            $closure->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
