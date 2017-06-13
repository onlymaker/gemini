<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;
use helper\Language;

class Index extends AppBase
{
    function get($f3)
    {
        $f3->set('title', '首页');
        $f3->set('languages', Language::all());
        echo \Template::instance()->render('index.html');
    }

    function search($f3)
    {
        $mapper = new Mapper($this->db, 'raw');
        $results = $mapper->find(['model = ?', trim($_GET['model'])], ['order' => 'update_time desc']);
        if ($results) {
            $f3->set('type', 'results');
            $f3->set('results', $results);
        } else {
            $hints = $this->db->exec('SELECT DISTINCT model FROM raw WHERE model like ?', trim($_GET['model'] . '%'));
            $f3->set('type', 'hints');
            $f3->set('hints', $hints);
        }
        $f3->set('title', '产品查找 ' . $_GET['model']);
        $f3->set('model', $_GET['model']);
        echo \Template::instance()->render('search.html');
    }

    function delete($f3)
    {
        $f3->log('Request to delete raw: ' . $_POST['id']);
        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_POST['id']]);
        if (!$mapper->dry()) {
            $f3->log('erase raw: ' . $mapper['id']);
            $mapper->erase();
        }
        $f3->log($this->db->log());
        $this->error['code'] = 0;
        echo $this->jsonResponse();
    }
}