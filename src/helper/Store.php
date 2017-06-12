<?php

namespace helper;

use data\Database;
use DB\SQL\Mapper;

class Store
{
    public static function get($name)
    {
        $store = new Mapper(Database::mysql(), 'store');
        $store->load(['name = ?', $name]);
        return $store->dry() ? [] : $store;
    }

    public static function create($name)
    {
        $store = new Mapper(Database::mysql(), 'store');
        $store['name'] = strtoupper($name);
        $store['market_unit'] = self::parseMarketUnit($name);
        $store['cdn'] = 'http://' . strtolower($name) . '.syncxplus.com';
        if ($store['market_unit'] == 'US') {
            $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/us_size_chart.png';
        } else {
            $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/eu_size_chart.png';
        }
        $store->save();
    }

    private static function parseMarketUnit($name)
    {
        $hash = [
            'EU' => ['EU'],
            'UK' => ['UK'],
            'US' => ['CA', 'US']
        ];

        foreach ($hash as $site => $suffixes) {
            foreach ($suffixes as $suffix) {
                $length = strlen($suffix);
                if ($length <= strlen($name) && stripos($name, $suffix, - $length) !== false) {
                    return $site;
                }
            }
        }

        \Base::instance()->log('WARN: the {name} doesn\'t match to any site suffix', ['name' => $name]);

        return strtoupper($name);
    }
}