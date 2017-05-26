<?php
namespace app\system;

use DB\SQL\Mapper;

class Upc extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'upc');
        $f3->set('title', 'UPC');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/upc.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $upc = new Mapper($this->db, 'upc');
        $upc->load(["data = ?", $data]);
        if ($upc->dry()) {
            $f3->log('Create upc ' . $data);
            $upc['data'] = strtoupper($data);
            $upc->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
