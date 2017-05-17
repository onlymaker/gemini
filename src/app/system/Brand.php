<?php
namespace app\system;

use DB\SQL\Mapper;

class Brand extends SysBase
{
    function get($f3)
    {
        $brand = $this->db->exec('SELECT distinct(name) FROM brand');
        foreach (array_column($brand, 'name') as $i => $name) {
            $results = array_column($this->db->exec("SELECT store_id as id FROM brand WHERE name = '$name'"), 'id');
            $brand[$i]['stores'] = implode(',', $results);
        }
        $f3->set('title', '  品牌管理');
        $f3->set('brand', $brand);
        $f3->set('stores', (new Store)->storeArray());
        echo \Template::instance()->render('system/brand.html');
    }

    function post($f3)
    {
        $stores = explode(',', $_POST['stores']);
        $name = $_POST['name'];
        $brand = new Mapper($this->db, 'brand');
        $brand->load(["name = ?", $name]);
        if ($brand->dry()) {
            $f3->log('Create brand ' . $name);
            foreach ($stores as $store) {
                $brand['name'] = strtoupper($name);
                $brand['store_id'] = $store;
                $brand->save();
                $brand->reset();
            }
        } else {
            $brand->reset();
            $prev = array_column($this->db->exec("SELECT store_id as id FROM brand WHERE name = '$name'"), 'id');
            $keep = array_intersect($stores, $prev);
            $create = array_diff($stores, $keep);
            $remove = array_diff($prev, $keep);
            foreach ($create as $item) {
                $brand['name'] = strtoupper($name);
                $brand['store_id'] = $item;
                $f3->log('create: ' . $item);
                $brand->save();
                $brand->reset();
            }
            foreach ($remove as $item) {
                $brand->erase(['name = ? and store_id = ?', $name, $item]);
            }
        }
        echo 'SUCCESS';
    }
}
