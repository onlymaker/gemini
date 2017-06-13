<?php
namespace app;

use app\common\AppBase;
use data\OMS;
use DB\SQL\Mapper;

class Create extends AppBase
{
    function get($f3)
    {
        $f3->set('title', 'Create');
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
        echo \Template::instance()->render('create.html');
    }

    function post($f3)
    {
        $data = json_encode($_POST, JSON_UNESCAPED_UNICODE);
        $model = $_POST['model'];
        $store = $_POST['store'];
        $brand = $_POST['brand'];
        $raw = new Mapper($this->db, 'raw');
        $raw->load(['model = ? and store = ? and brand = ? and language = ? and user = ?', $model, $store, $brand, $this->language, $this->user['name']]);
        if ($raw->dry()) {
            $raw['model'] = $model;
            $raw['store'] = $store;
            $raw['brand'] = $brand;
            $raw['language'] = $this->language;
            $raw['user'] = $this->user['name'];
            $raw['data'] = $data;
            $raw->save();
        } else {
            if ($raw['data'] != $data) {
                $raw['data'] = $data;
                $raw->save();
            }
        }
        $this->error['code'] = 0;
        echo $this->jsonResponse();
    }

    function checkModel()
    {
        $mapper = new Mapper(OMS::instance(), 'prototype');
        $mapper->load(['model = ?', $_GET['model']]);
        if (!$mapper->dry()) {
            $this->error['code'] = 0;
        }
        echo $this->jsonResponse();
    }
}
