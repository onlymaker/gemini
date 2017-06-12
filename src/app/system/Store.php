<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Store extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'store');
        $f3->set('title', '商店管理');
        $f3->set('stores', $mapper->find());
        echo \Template::instance()->render('system/store.html');
    }

    function create($f3)
    {
        $name = $_POST['name'];
        $store = new Mapper($this->db, 'store');
        $store->load(["name = ?", $name]);
        if ($store->dry()) {
            $f3->log('Create store ' . $name);
            $store['name'] = strtoupper($name);
            $store['cdn'] = 'http://' . strtolower($name) . '.syncxplus.com';
            if (self::getSite($name) == 'US') {
                $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/us_size_chart.png';
            } else {
                $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/eu_size_chart.png';
            }
            $store->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }

    public static function getStore($name)
    {
        $store = new Mapper(Database::mysql(), 'store');
        $store->load(['name = ?', $name]);
        return $store->dry() ? [] : $store;
    }

    /**
     * Mapping store to site [EU, UK, US]
     * @param $store       : store name
     * @return mixed|string: site
     */
    public static function getSite($store)
    {
        $hash = [
            'EU' => ['EU'],
            'UK' => ['UK'],
            'US' => ['CA', 'US']
        ];

        foreach ($hash as $site => $suffixes) {
            foreach ($suffixes as $suffix) {
                $length = strlen($suffix);
                if ($length <= strlen($store) && stripos($store, $suffix, - $length) !== false) {
                    return $site;
                }
            }
        }

        \Base::instance()->log('WARN: the {store} doesn\'t match to any site suffix', ['store' => $store]);

        return strtoupper($store);
    }
}
