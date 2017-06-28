<?php

namespace helper;

use data\Database;
use DB\SQL\Mapper;

class Store
{
    private static $MARKET_UNIT_HASH = [
        'DE' => ['EU'],
        'UK' => ['UK'],
        'US' => ['CA', 'US']
    ];

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
        $store['cdn'] = 'http://' . strtolower($name) . '.syncxplus.com';
        $store['market_unit'] = self::parseMarketUnit($name);
        if ($store['market_unit'] == 'US') {
            $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/us_size_chart.png';
        } else {
            $store['swatch_image_url'] = 'http://' . strtolower($name) . '.syncxplus.com/eu_size_chart.png';
        }
        $store->save();
    }

    public static function languages()
    {
        return ['us', 'uk', 'de'];
    }

    private static function parseMarketUnit($name)
    {
        foreach (self::$MARKET_UNIT_HASH as $marketUnit => $suffixes) {
            foreach ($suffixes as $suffix) {
                $length = strlen($suffix);
                if ($length <= strlen($name) && stripos($name, $suffix, - $length) !== false) {
                    return $marketUnit;
                }
            }
        }

        \Base::instance()->log('WARN: the {name} doesn\'t match to any market unit', ['name' => $name]);

        return $name;
    }
}
