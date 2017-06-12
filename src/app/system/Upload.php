<?php
namespace app\system;

use app\common\Url;
use data\Database;
use DB\SQL\Mapper;
use helper\Store;

class Upload extends \Web
{
    use Url;

    function get($f3)
    {
        $f3->set('title', 'Upload');
        echo \Template::instance()->render('system/upload.html');
    }

    function post($f3)
    {
        $table = $_GET['table'];

        if (empty($table)) {
            echo json_encode(['name' => 'table required', 'type' => 'table required', 'url' => ''], JSON_UNESCAPED_UNICODE);
            return;
        }

        list($receive) = array_keys(parent::receive(null, true, false));

        $f3->log('receive: ' . $receive);

        $name = preg_replace('/^.+[\\\\\\/]/', '', $receive);

        if (is_file($receive)) {
            $type = $this->mime($receive);
            if ($type == 'application/vnd.ms-excel') {
                $this->excel2table($receive, $table);
                $url = $this->url(substr($f3->get('UPLOADS'), strlen($f3->get('ROOT'))) . $name);
            } else {
                unlink($receive);
            }
        }

        echo json_encode(['name' => $name, 'type' => $type, 'url' => $url], JSON_UNESCAPED_UNICODE);
    }

    function beforeRoute($f3)
    {
        if ($f3->get('AJAX')) {
            header('Access-Control-Allow-Origin:*');
        }
    }

    function excel2table($file, $table) {
        @ini_set('memory_limit', '256M');
        $excel = \PHPExcel_IOFactory::load($file);
        $sheet = $excel->getSheet(0);
        $rows = $sheet->toArray();
        $f3 = \Base::instance();
        $mapper = new Mapper(Database::mysql(), $table);
        foreach ($rows as $i => $data) {
            if ($table == 'generic_keyword') {//name,data,language
                $keywordString = trim(str_replace('，', ',', $data[1]));
                $mapper->load(["name = ? and language = ?", $data[0], $data[2] ?? 'en']);
                if ($mapper->dry()) {
                    $mapper['name'] = strtolower($data[0]);
                    $mapper['data'] = $keywordString;
                    $mapper['language'] = $data[2] ?? 'en';
                    $mapper->save();
                    $f3->log($table . ': ' . $data[0] . ' created');
                } else {
                    if ($mapper['data'] != $keywordString) {
                        $mapper['data'] = $keywordString;
                        $mapper->save();
                        $f3->log($table . ': ' . $data[0] . ' updated');
                    } else {
                        $f3->log($table . ': ' . $data[0] . ' existed');
                    }
                }
            } else if ($table == 'store') {//name
                $mapper->load(["name = ?", $data[0]]);
                if ($mapper->dry()) {
                    Store::create($data[0]);
                    $f3->log($table . ': ' . $data[0] . ' created');
                } else {
                    $f3->log($table . ': ' . $data[0] . ' existed');
                }
            } else if (in_array($table, ['brand', 'upc'])) {//data
                $mapper->load(["data = ?", $data[0]]);
                if ($mapper->dry()) {
                    $mapper['data'] = $data[0];
                    $mapper->save();
                    $f3->log($table . ': ' . $data[0] . ' created');
                } else {
                    $f3->log($table . ': ' . $data[0] . ' existed');
                }
            } else {//data,language
                $mapper->load(["data = ? and language = ?", $data[0], $data[1] ?? 'en']);
                if ($mapper->dry()) {
                    $mapper['data'] = $data[0];
                    $mapper['language'] = $data[1];
                    $mapper->save();
                    $f3->log($table . ': ' . $data[0] . ' created');
                } else {
                    $f3->log($table . ': ' . $data[0] . ' existed');
                }
            }
        }
    }
}
