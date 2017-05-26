<?php
namespace app\system;

use DB\SQL\Mapper;

class Material extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'material');
        $f3->set('title', 'Material');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/material.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $Material = new Mapper($this->db, 'material');
        $Material->load(["data = ?", $data]);
        if ($Material->dry()) {
            $f3->log('Create material ' . $data);
            $Material['data'] = strtoupper($data);
            $Material->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
