<?php
namespace app;

use app\common\AppBase;
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
        $mapper = new Mapper($this->db, 'raw');
        $results = $mapper->find(['model like ?', '%' . $_GET['model'] . '%']);
        $data = [];
        foreach ($results as $result) {
            $data[] = [
                'id' => $result['id'],
                'user' => $result['user'],
                'model' => $result['model'],
                'store' => $result['store'],
                'brand' => $result['brand'],
                'create_time' => $result['create_time']
            ];
        }
        $f3->log($this->db->log());
        $this->error['code'] = 0;
        echo $this->jsonResponse(['results' => $data]);
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