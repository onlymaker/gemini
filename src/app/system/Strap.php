<?php
namespace app\system;

use DB\SQL\Mapper;

class Strap extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'strap');
        $f3->set('title', 'Strap');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/strap.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $strap = new Mapper($this->db, 'strap');
        $strap->load(["name = ?", $name]);
        if ($strap->dry()) {
            $f3->log('Create strap ' . $name);
            $strap['name'] = strtoupper($name);
            $strap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
