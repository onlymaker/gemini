<?php
namespace app\system;

use DB\SQL\Mapper;

class HeightMap extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'height_map');
        $f3->set('title', 'Height Map');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/height_map.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $heightMap = new Mapper($this->db, 'height_map');
        $heightMap->load(["name = ?", $name]);
        if ($heightMap->dry()) {
            $f3->log('Create height map ' . $name);
            $heightMap['name'] = strtoupper($name);
            $heightMap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
