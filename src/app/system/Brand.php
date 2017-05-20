<?php
namespace app\system;

use DB\SQL\Mapper;

class Brand extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'brand');
        $f3->set('title', 'Brand');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/brand.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $brand = new Mapper($this->db, 'brand');
        $brand->load(["name = ?", $name]);
        if ($brand->dry()) {
            $f3->log('Create brand ' . $name);
            $brand['name'] = strtoupper($name);
            $brand->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
