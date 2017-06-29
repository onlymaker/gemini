<?php
namespace app;

use app\common\AppBase;
use data\OMS;
use DB\SQL\Mapper;

class Index extends AppBase
{
    function get($f3)
    {
        $f3->set('title', '首页');
        echo \Template::instance()->render('index.html');
    }

    function search($f3)
    {
        $results = [];
        $mapper = new Mapper($this->db, 'raw');
        $data = $mapper->find(['model = ?', trim($_GET['model'])], ['order' => 'update_time desc']);
        if ($data) {
            foreach ($data as $i => $result) {
                $results[$i] = $result->cast();
                $results[$i]['image'] = $this->getImage($result['model']);
            }
            $f3->set('type', 'results');
            $f3->set('results', $results);
        } else {
            $hints = [];
            $data = $this->db->exec('SELECT DISTINCT model FROM raw WHERE model like ?', trim($_GET['model']) . '%');
            foreach ($data as $i => $hint) {
                $hints[$i] = ['model' => $hint['model']];
                $hints[$i]['image'] = $this->getImage($hint['model']);
            }
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

    function getImage($model)
    {
        $oms = OMS::instance();
        $prototype = new Mapper($oms, 'prototype');
        $prototype->load(['model = ?', $model]);
        if (!$prototype->dry() && !empty($prototype['images'])) {
            $images = explode(',', $prototype['images']);
            return $images[0] . '?imageView2/0/w/100';
        } else {
            return 'http://qiniu.syncxplus.com/meta/holder.jpg?imageView2/0/w/100';
        }
    }
}
