<?php
namespace app\system;

use DB\SQL\Mapper;

class Lifestyle extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'lifestyle');
        $f3->set('title', 'lifestyle');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/lifestyle.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $lifestyle = new Mapper($this->db, 'lifestyle');
        $lifestyle->load(["data = ?", $data]);
        if ($lifestyle->dry()) {
            $f3->log('Create lifestyle ' . $data);
            $lifestyle['data'] = strtoupper($data);
            $lifestyle->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
