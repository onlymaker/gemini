<?php
namespace app\system;

use DB\SQL\Mapper;

class Heel extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'heel');
        $f3->set('title', 'Heel');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/heel.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $heel = new Mapper($this->db, 'heel');
        $heel->load(["data = ?", $data]);
        if ($heel->dry()) {
            $f3->log('Create heel ' . $data);
            $heel['data'] = strtoupper($data);
            $heel->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
