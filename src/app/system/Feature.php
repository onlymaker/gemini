<?php
namespace app\system;

use DB\SQL\Mapper;

class Feature extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'feature');
        $f3->set('title', 'Feature');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/feature.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $feature = new Mapper($this->db, 'feature');
        $feature->load(["data = ?", $data]);
        if ($feature->dry()) {
            $f3->log('Create feature ' . $data);
            $feature['data'] = strtoupper($data);
            $feature->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
