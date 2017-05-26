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
        $data = $_POST['data'];
        $strap = new Mapper($this->db, 'strap');
        $strap->load(["data = ?", $data]);
        if ($strap->dry()) {
            $f3->log('Create strap ' . $data);
            $strap['data'] = strtoupper($data);
            $strap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
