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
            if ($mapper['language'] != $this->language) {
                $raw = new Mapper($this->db, 'raw');
                // try to load existed raw data with specified language and login user
                $raw->load(['model = ? and store = ? and brand = ? and language = ? and user = ?', $mapper['model'], $mapper['store'], $mapper['brand'], $this->language, $this->user['name']]);
                if ($raw->dry() && $this->user['name'] != $mapper['user']) {
                    // try to load existed raw data with specified language and user
                    $raw->load(['model = ? and store = ? and brand = ? and language = ? and user = ?', $mapper['model'], $mapper['store'], $mapper['brand'], $this->language, $mapper['user']]);
                }
                if ($raw->dry()) {
                    $data = $this->translateRaw($mapper['data'], $this->language);
                } else {
                    $data = $raw['data'];
                }
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

            $f3->set('data', json_decode($data ?? $mapper['data'], true));
            $f3->set('languages', Store::languages());

            echo \Template::instance()->render('edit.html');
        }
    }

    function translateRaw($raw, $language)
    {
        $data = json_decode($raw, true);

        $clearProperties = [
            'store',
            'price',
            'currency',
            'size'
        ];
        foreach ($clearProperties as $property) {
            $data[$property] = '';
        }

        $simpleProperties = [
            'itemType',
            'heel',
            'strap',
            'closure',
            'pattern',
            'toe',
            'lifestyle',
            'material',
            'heightMap',
        ];
        $simpleTables = [
            'item_type',
            'heel',
            'strap',
            'closure',
            'pattern',
            'toe',
            'lifestyle',
            'material',
            'height_map',
        ];
        foreach ($simpleProperties as $i => $property) {
            if (!empty($data[$property])) {
                $data[$property] = $this->translate($simpleTables[$i], $data[$property], $language);
            }
        }

        //keyword,feature,sku(color_map)
        $objProperties = [
            'keyword',
            'feature',
            'sku'
        ];
        foreach ($objProperties as $objProperty) {
            if ($objProperty == 'sku') {
                foreach ($data['sku'] as &$sku) {
                    if (!empty($sku['colorMap'])) {
                        $sku = $this->translate('color_map', $sku['colorMap'], $language);
                    }
                }
            } else {
                foreach ($data[$objProperty] as &$property) {
                    if (!empty($property)) {
                        $property = $this->translate($objProperty, $property, $language);
                    }
                }
            }
        }

        //bulletPoint
        foreach ($data['bulletPoint'] as &$bulletPoint) {
            $bulletPoint = $this->translate('generic_keyword', $bulletPoint, $language);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function translate($table, $default, $language)
    {
        $mapper = new Mapper($this->db, $table);
        $mapper->load(['us = ?', $default]);
        @\Base::instance()->log('translate {from} => {to}', [
            'from' => $default,
            'to' => $mapper->$language
        ]);
        return $mapper->dry() ? '' : $mapper->$language;
    }
}
