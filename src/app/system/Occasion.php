<?php
namespace app\system;

use DB\SQL\Mapper;

class Occasion extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'occasion');
        $f3->set('title', 'Occasion');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/occasion.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $occasion = new Mapper($this->db, 'occasion');
        $occasion->load(["name = ?", $name]);
        if ($occasion->dry()) {
            $f3->log('Create occasion ' . $name);
            $occasion['name'] = strtoupper($name);
            $occasion->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
