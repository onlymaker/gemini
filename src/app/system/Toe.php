<?php
namespace app\system;

use DB\SQL\Mapper;

class Toe extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'toe');
        $f3->set('title', 'Toe');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/toe.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $toe = new Mapper($this->db, 'toe');
        $toe->load(["name = ?", $name]);
        if ($toe->dry()) {
            $f3->log('Create toe ' . $name);
            $toe['name'] = strtoupper($name);
            $toe->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
