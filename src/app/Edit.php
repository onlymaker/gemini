<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;
use helper\Store;

class Edit extends AppBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_GET['id']]);
        if ($mapper->dry()) {
            header('HTTP/1.1 404 Not Found');
        } else {
            if ($mapper['language'] == $this->language) {
                $data = $mapper['data'];
            } else {
                $data = $this->translate($mapper);
            }

            $f3->set('title', 'Edit');
            $f3->set('stores', (new Mapper($this->db, 'store'))->find(null, ['order' => 'name']));
            $f3->set('brands', (new Mapper($this->db, 'brand'))->find(null, ['order' => 'name']));
            $f3->set('itemTypes', (new Mapper($this->db, 'item_type'))->find(null, ['order' => $this->language]));
            $f3->set('heels', (new Mapper($this->db, 'heel'))->find(null, ['order' => $this->language]));
            $f3->set('straps', (new Mapper($this->db, 'strap'))->find(null, ['order' => $this->language]));
            $f3->set('closures', (new Mapper($this->db, 'closure'))->find(null, ['order' => $this->language]));
            $f3->set('patterns', (new Mapper($this->db, 'pattern'))->find(null, ['order' => $this->language]));
            $f3->set('toes', (new Mapper($this->db, 'toe'))->find(null, ['order' => $this->language]));
            $f3->set('lifestyles', (new Mapper($this->db, 'lifestyle'))->find(null, ['order' => $this->language]));
            $f3->set('materials', (new Mapper($this->db, 'material'))->find(null, ['order' => $this->language]));
            $f3->set('heightMaps', (new Mapper($this->db, 'height_map'))->find(null, ['order' => $this->language]));
            $f3->set('keywords', (new Mapper($this->db, 'keyword'))->find(null, ['order' => $this->language]));
            $f3->set('features', (new Mapper($this->db, 'feature'))->find(null, ['order' => $this->language]));
            $f3->set('colorMaps', (new Mapper($this->db, 'color_map'))->find(null, ['order' => $this->language]));

            $f3->set('data', json_decode($data, true));
            $f3->set('languages', Store::languages());

            echo \Template::instance()->render('edit.html');
        }
    }

    function translate($raw)
    {
        return $raw['data'];
    }
}
