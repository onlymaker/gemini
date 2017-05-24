<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;

class Create extends AppBase
{
    function get($f3)
    {
        $f3->set('title', 'Create');
        $f3->set('stores', (new Mapper($this->db, 'store'))->find(null, ['order' => 'name']));
        $f3->set('brands', (new Mapper($this->db, 'brand'))->find(null, ['order' => 'name']));
        $f3->set('itemTypes', (new Mapper($this->db, 'item_type'))->find(null, ['order' => 'name']));
        $f3->set('heels', (new Mapper($this->db, 'heel'))->find(null, ['order' => 'name']));
        $f3->set('straps', (new Mapper($this->db, 'strap'))->find(null, ['order' => 'name']));
        $f3->set('closures', (new Mapper($this->db, 'closure'))->find(null, ['order' => 'name']));
        $f3->set('patterns', (new Mapper($this->db, 'pattern'))->find(null, ['order' => 'name']));
        $f3->set('toes', (new Mapper($this->db, 'toe'))->find(null, ['order' => 'name']));
        $f3->set('occasions', (new Mapper($this->db, 'occasion'))->find(null, ['order' => 'name']));
        $f3->set('materials', (new Mapper($this->db, 'material'))->find(null, ['order' => 'name']));
        $f3->set('heightMaps', (new Mapper($this->db, 'height_map'))->find(null, ['order' => 'name']));
        $f3->set('keywords', (new Mapper($this->db, 'keyword'))->find(null, ['order' => 'name']));
        $f3->set('features', (new Mapper($this->db, 'feature'))->find(null, ['order' => 'name']));
        $f3->set('colorMaps', (new Mapper($this->db, 'color_map'))->find(null, ['order' => 'name']));
        echo \Template::instance()->render('create.html');
    }

    function post($f3)
    {
        $data = json_encode($_POST, JSON_UNESCAPED_UNICODE);
        $f3->log($data);
        $raw = new Mapper($this->db, 'raw');
        $raw['user'] = $this->user['name'];
        $raw['model'] = $_POST['model'] ?? 'undefined';
        $raw['store'] = $_POST['store'] ?? 'undefined';
        $raw['brand'] = $_POST['brand'] ?? 'undefined';
        $raw['data'] = $data;
        $raw->save();
        $this->error['code'] = 0;
        echo $this->jsonResponse();
    }
}