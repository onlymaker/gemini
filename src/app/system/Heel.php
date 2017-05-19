<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Heel extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper(Database::mysql(), 'heel');
        $f3->set('title', 'Heel');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/heel.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $heel = new Mapper($this->db, 'heel');
        $heel->load(["name = ?", $name]);
        if ($heel->dry()) {
            $f3->log('Create heel ' . $name);
            $heel['name'] = strtoupper($name);
            $heel->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
