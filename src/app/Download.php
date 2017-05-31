<?php
namespace app;

use app\common\AppBase;
use DB\SQL\Mapper;
use helper\AmazonTemplate;

class Download extends AppBase
{
    function get($f3)
    {
        $mapper = new Mapper($this->db, 'raw');
        $mapper->load(['id = ?', $_GET['id']]);
        if ($mapper->dry()) {
            header('HTTP/1.1 404 Not Found');
        } else {
            $csv = '/tmp/' . $mapper['model'] . date('_Ymd') . '.csv';
            AmazonTemplate::generate(json_decode($mapper['data'], true), $csv);
            if (is_file($csv)) {
                echo file_get_contents($csv);
            } else {
                header('HTTP/1.1 404 Not Found');
            }
        }
    }
}
