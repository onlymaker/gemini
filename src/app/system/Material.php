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
        $name = $_POST['name'];
        $Material = new Mapper($this->db, 'material');
        $Material->load(["name = ?", $name]);
        if ($Material->dry()) {
            $f3->log('Create material ' . $name);
            $Material['name'] = strtoupper($name);
            $Material->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
