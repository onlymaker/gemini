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
        $data = $_POST['data'];
        $toe = new Mapper($this->db, 'toe');
        $toe->load(["data = ?", $data]);
        if ($toe->dry()) {
            $f3->log('Create toe ' . $data);
            $toe['data'] = strtoupper($data);
            $toe->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
