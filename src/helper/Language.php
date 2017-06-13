<?php

namespace helper;

use data\Database;
use DB\SQL\Mapper;

class Language
{
    private static $LANGUAGES = [];

    static function all(bool $reload = false)
    {
        if (!self::$LANGUAGES || $reload) {
            $mapper = new Mapper(Database::mysql(), 'language');
            $results = $mapper->find();
            foreach ($results as $result) {
                self::$LANGUAGES[] = $result['code'];
            }
        }
        return self::$LANGUAGES;
    }

    static function add($language)
    {
        $mapper = new Mapper(Database::mysql(), 'language');
        $mapper->load(['code = ?', $language]);
        if ($mapper->dry()) {
            $mapper['code'] = $language;
            $mapper->save();
            self::all(true);
        }
    }

    static function exists($language)
    {
        self::all(true);
        return in_array($language, self::$LANGUAGES);
    }
}