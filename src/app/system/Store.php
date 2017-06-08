<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Store extends SysBase
{
    function get($f3)
    {
        $f3->set('title', '商店管理');
        $f3->set('stores', $this->stores());
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

    function stores()
    {
        $store = new Mapper($this->db ?? Database::mysql(), 'store');
        return $store->find();
    }

    /**
     * Mapping store to site [EU, UK, US]
     * @param $store       : store name
     * @return mixed|string: site
     */
    public static function getSite($store)
    {
        switch (strtoupper($store)) {
            case 'OMDE':
            case 'KHDE':
            case 'OSDE':
                return 'EU';
            case 'OMUK':
            case 'KHUK':
            case 'OSUK':
                return 'UK';
            case 'AHUS':
            case 'CLUS':
            case 'OMCA':
            case 'OSUS':
                return 'US';
            default:
                return $store;
        }
    }
}
