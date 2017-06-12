<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;

class Edit extends AppBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_GET['id']]);
        if ($mapper->dry()) {
            header('HTTP/1.1 404 Not Found');
        } else {
            $f3->set('title', 'Edit');
            $f3->set('data', json_decode($mapper['data'], true));
            if ($this->language != $mapper['language']) {
                $this->language = $mapper['language'];
                setcookie('language', $mapper['language'], 0, '/');
                $f3->set('language', $mapper['language']);
            }
            $f3->set('stores', (new Mapper($this->db, 'store'))->find(null, ['order' => 'name']));
            $f3->set('brands', (new Mapper($this->db, 'brand'))->find(null, ['order' => 'data']));
            $f3->set('itemTypes', (new Mapper($this->db, 'item_type'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('heels', (new Mapper($this->db, 'heel'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('straps', (new Mapper($this->db, 'strap'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('closures', (new Mapper($this->db, 'closure'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('patterns', (new Mapper($this->db, 'pattern'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('toes', (new Mapper($this->db, 'toe'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('lifestyles', (new Mapper($this->db, 'lifestyle'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('materials', (new Mapper($this->db, 'material'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('heightMaps', (new Mapper($this->db, 'height_map'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('keywords', (new Mapper($this->db, 'keyword'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('features', (new Mapper($this->db, 'feature'))->find(['language = ?', $this->language], ['order' => 'data']));
            $f3->set('colorMaps', (new Mapper($this->db, 'color_map'))->find(['language = ?', $this->language], ['order' => 'data']));
            echo \Template::instance()->render('edit.html');
        }
    }
}
