<?php
namespace app\system;

use DB\SQL\Mapper;

class Pattern extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'pattern');
        $f3->set('title', 'Pattern');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/pattern.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $pattern = new Mapper($this->db, 'pattern');
        $pattern->load(["data = ?", $data]);
        if ($pattern->dry()) {
            $f3->log('Create pattern ' . $data);
            $pattern['data'] = strtoupper($data);
            $pattern->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
