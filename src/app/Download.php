<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;
use helper\AmazonTemplate;

class Download extends AppBase
{
    function get($f3)
    {
        $f3->log("Request download {id} by {user}", ['id' => $_GET['id'], 'user' => $this->user['name']]);

        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_GET['id']]);

        if ($mapper->dry()) {
            $f3->log("Request download {id} not found", ['id' => $_GET['id']]);
            header('HTTP/1.1 404 Not Found');
        } else {
            $csv = '/tmp/' . $mapper['model'] . date('_Ymd') . '.csv';

            header('Content-Type: octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($csv) . '"');

            $data = json_decode($mapper['data'], true);
            $data['upc'] = $_GET['upc'];

            ob_start();
            var_dump($data);
            $f3->log(ob_get_clean());

            AmazonTemplate::generate($data, $csv);

            echo file_get_contents($csv);
        }
    }
}
