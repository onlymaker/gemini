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
        $data = $_POST['data'];
        $store = new Mapper($this->db, 'store');
        $store->load(["data = ?", $data]);
        if ($store->dry()) {
            $f3->log('Create store ' . $data);
            $store['data'] = strtoupper($data);
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

    function storeArray()
    {
        $data = [];
        $stores = $this->stores();
        foreach ($stores as $item) {
            $data[] = [
                'id' => $item['id'],
                'data' => $item['data']
            ];
        }
        return $data;
    }
}
