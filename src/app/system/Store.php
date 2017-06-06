<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Store extends SysBase
{
    function get($f3)
    {
        $f3->set('title', '商店管理');
        $f3->set('stores', $this->stores());
        echo \Template::instance()->render('system/store.html');
    }

    function create($f3)
    {
        $name = $_POST['name'];
        $store = new Mapper($this->db, 'store');
        $store->load(["name = ?", $name]);
        if ($store->dry()) {
            $f3->log('Create store ' . $name);
            $store['name'] = strtoupper($name);
            $store['cdn'] = 'http://' . strtolower($name) . '.syncxplus.com';
            $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/swatch.jpg';
            $store->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }

    function stores()
    {
        $store = new Mapper($this->db ?? Database::mysql(), 'store');
        return $store->find();
    }
}
