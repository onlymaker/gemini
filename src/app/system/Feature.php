<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Feature extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper(Database::mysql(), 'feature');
        $f3->set('title', 'Feature');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/feature.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $feature = new Mapper($this->db, 'feature');
        $feature->load(["name = ?", $name]);
        if ($feature->dry()) {
            $f3->log('Create feature ' . $name);
            $feature['name'] = strtoupper($name);
            $feature->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
