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
        $name = $_POST['name'];
        $pattern = new Mapper($this->db, 'pattern');
        $pattern->load(["name = ?", $name]);
        if ($pattern->dry()) {
            $f3->log('Create pattern ' . $name);
            $pattern['name'] = strtoupper($name);
            $pattern->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
