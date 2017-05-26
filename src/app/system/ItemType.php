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
        $data = $_POST['data'];
        $itemType = new Mapper($this->db, 'item_type');
        $itemType->load(["data = ?", $data]);
        if ($itemType->dry()) {
            $f3->log('Create item type ' . $data);
            $itemType['data'] = strtoupper($data);
            $itemType->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
