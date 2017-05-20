<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class ColorMap extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper(Database::mysql(), 'color_map');
        $f3->set('title', 'ColorMap');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/color_map.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $colorMap = new Mapper($this->db, 'color_map');
        $colorMap->load(["name = ?", $name]);
        if ($colorMap->dry()) {
            $f3->log('Create color map ' . $name);
            $colorMap['name'] = strtoupper($name);
            $colorMap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
