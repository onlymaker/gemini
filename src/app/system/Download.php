<?php
namespace app\system;

use DB\SQL\Mapper;

class Download extends SysBase
{

    function get($f3)
    {
        $table = $_GET['table'];

        if (empty($table) || !$this->db->exec('SHOW TABLES LIKE ?', $table)) {
            header('HTTP/1.1 404 Not Found');
        } else if ($table == 'raw') {
            echo 'raw data is not allowed to download';
        } else {
            $dir = SYSTEM . '/downloads/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $dir . $table . date('_Ymd') . '.csv';

            header('Content-Type: octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');

            $csv = fopen($file, 'w');

            $count = 0;
            $mapper = new Mapper($this->db, $table);
            $mapper->load();

            while (!$mapper->dry()) {
                if ($count === 0) {
                    fputcsv($csv, $mapper->fields());
                }
                fputcsv($csv, $mapper->cast());
                ob_flush();
                flush();
                $count ++;
                $mapper->next();
            }

            fclose($csv);

            echo file_get_contents($file);
        }
    }
}
