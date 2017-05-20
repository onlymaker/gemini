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
                'create_time' => $result['create_time']
            ];
        }
        $f3->log($this->db->log());
        $this->error['code'] = 0;
        echo $this->jsonResponse(['results' => $data]);
    }
}
