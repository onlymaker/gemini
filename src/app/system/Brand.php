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
        $data = $_POST['data'];
        $brand = new Mapper($this->db, 'brand');
        $brand->load(["data = ?", $data]);
        if ($brand->dry()) {
            $f3->log('Create brand ' . $data);
            $brand['data'] = strtoupper($data);
            $brand->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
