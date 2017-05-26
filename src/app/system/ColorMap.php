<?php
namespace app\system;

use DB\SQL\Mapper;

class ColorMap extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'color_map');
        $f3->set('title', 'ColorMap');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/color_map.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $colorMap = new Mapper($this->db, 'color_map');
        $colorMap->load(["data = ?", $data]);
        if ($colorMap->dry()) {
            $f3->log('Create color map ' . $data);
            $colorMap['data'] = strtoupper($data);
            $colorMap->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
