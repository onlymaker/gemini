<?php
namespace app\system;

use data\Database;
use DB\SQL\Mapper;

class Keyword extends SysBase
{
    function get($f3)
    {
        $mapper = new Mapper(Database::mysql(), 'keyword');
        $f3->set('title', 'Keyword');
        $f3->set('results', $mapper->find());
        echo \Template::instance()->render('system/keyword.html');
    }

    function post($f3)
    {
        $name = $_POST['name'];
        $keyword = new Mapper($this->db, 'keyword');
        $keyword->load(["name = ?", $name]);
        if ($keyword->dry()) {
            $f3->log('Create keyword ' . $name);
            $keyword['name'] = strtoupper($name);
            $keyword->save();
            echo 'SUCCESS';
        } else {
            echo 'EXISTED';
        }
    }
}
