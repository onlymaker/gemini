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
            } else {
                $data = $mapper['data'];
            }
            $data = json_decode($data, true);
            $this->pregReplace($data);

            $f3->set('data', $data);
            $f3->set('languages', Store::languages());

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

            echo \Template::instance()->render('edit.html');
        }
    }

    function pregReplace(&$data, $pattern = '/\f|\n|\r|\t|\v/')
    {
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                $this->pregReplace($value);
            } else {
                $data[$key] = preg_replace($pattern, ' ', $value);
            }
        }
    }

    function translateRaw($raw, $language)
    {
        /*
         * 四种类型标志：
         * 需要重新填写的属性：clear
         * 直接按词典替换：string(table name)
         * 属性为字符串数组，每个元素按照词典替换：[table name]
         * 属性为object，每个元素指定需要替换的字段和表名：[[object field, table name], ...]
         */
        $propertyMap = [
            'store' => 'clear',
            'price' => 'clear',
            'bulletPoint' => ['clear'],
            'itemType' => 'item_type',
            'heel' => 'heel',
            'strap' => 'strap',
            'closure' => 'closure',
            'pattern' => 'pattern',
            'toe' => 'toe',
            'lifestyle' => 'lifestyle',
            'material' => 'material',
            'heightMap' => 'height_map',
            'feature' => ['feature'],
            'keyword' => ['keyword'],
            'sku' => [
                ['colorMap' => 'color_map']
            ]
        ];
        $data = json_decode($raw, true);

        foreach ($propertyMap as $key => $value) {
            if (is_string($value)) {
                if (!empty($data[$key])) {
                    if ($value == 'clear') {
                        $data[$key] = '';
                    } else {
                        $data[$key] = $this->translate($value, $data[$key], $language);
                    }
                }
            } else if (is_string($value[0])) {
                foreach ($data[$key] as &$default) {
                    if (!empty($default)) {
                        if ($value[0] == 'clear') {
                            $default = '';
                        } else {
                            $default = $this->translate($value[0], $default, $language);
                        }
                    }
                }
            } else {
                foreach ($data[$key] as &$obj) {
                    foreach ($value as $property => $table) {
                        if (!empty($obj[$property])) {
                            $obj[$property] = $this->translate($table, $obj[$property], $language);
                        }
                    }
                }
            }
        }

        $currencyMap = [
            'de' => 'EUR',
            'uk' => 'GBP'
        ];
        $data['currency'] = $currencyMap[$language];

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
