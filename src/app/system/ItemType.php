<?php
namespace app\system;

use DB\SQL\Mapper;

class ItemType extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'item_type');
        $f3->set('title', '产品类型管理');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/item_type.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $itemType = new Mapper($this->db, 'item_type');
        $itemType->load(["name = ?", $name]);
        if ($itemType->dry()) {
            $f3->log('Create item type ' . $name);
            $itemType['name'] = strtoupper($name);
            $itemType->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
