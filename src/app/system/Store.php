<?php
namespace app\system;

use DB\SQL\Mapper;

class Store extends SysBase
{
    function get($f3)
    {
        $store = new Mapper($this->db, 'store');
        $stores = $store->find();
        $f3->set('title', '  用户管理');
        $f3->set('stores', $stores);
        echo \Template::instance()->render('system/store.html');
    }

    function create($f3)
    {
        $name = $_POST['name'];
        $store = new Mapper($this->db, 'store');
        $store->load(["name = ?", $name]);
        if ($store->dry()) {
            $f3->log('Create store ' . $name);
            $store['name'] = $name;
            $store->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
