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
            $file = $dir . $this->user['name'] . '_' . $table . date('_Ymd') . '.csv';

            $csv = fopen($file, 'w');

            $count = 0;
            $mapper = new Mapper($this->db, $table);
            $mapper->load();

            while (!$mapper->dry()) {
                $fields = $mapper->fields(true);
                if ($count === 0) {
                    fputcsv($csv, array_keys($fields));
                }
                fputcsv($csv, $fields);
                $count ++;
                $mapper->next();
            }

            fclose($csv);

            header('Content-Type: octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            echo file_get_contents($file);
        }
    }
}
