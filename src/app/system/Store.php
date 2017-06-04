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
            $store['cdn'] = $_POST['cdn'] ?? '';
            $store['swatch_image_url'] = $_POST['swatchImageUrl'];
            $store->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }

    function delete()
    {
        $id = $_POST['id'];
        $store = new Mapper($this->db, 'store');
        $store->load(["id = ?", $id]);
        if ($store->dry()) {
            echo 'Store [' . $id . '] not found';
        } else {
            $store->erase();
            echo 'SUCCESS';
        }
    }

    function stores()
    {
        $store = new Mapper($this->db ?? Database::mysql(), 'store');
        return $store->find();
    }
}
