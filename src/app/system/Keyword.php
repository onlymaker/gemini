<?php
namespace app\system;

use DB\SQL\Mapper;

class Keyword extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'keyword');
        $f3->set('title', 'Keyword');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/keyword.html');
    }

    function post($f3)
    {
        $data = $_POST['data'];
        $keyword = new Mapper($this->db, 'keyword');
        $keyword->load(["data = ?", $data]);
        if ($keyword->dry()) {
            $f3->log('Create keyword ' . $data);
            $keyword['data'] = strtoupper($data);
            $keyword->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
