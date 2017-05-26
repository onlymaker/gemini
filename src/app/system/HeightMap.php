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
        $data = $_POST['data'];
        $heightMap = new Mapper($this->db, 'height_map');
        $heightMap->load(["data = ?", $data]);
        if ($heightMap->dry()) {
            $f3->log('Create height map ' . $data);
            $heightMap['data'] = strtoupper($data);
            $heightMap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
