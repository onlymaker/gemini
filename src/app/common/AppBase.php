<?php
namespace app\common;

use data\Database;
use data\OMS;
use DB\SQL\Mapper;

class AppBase
{
    use Url;

    protected $error = ['code' => -1, 'text' => 'Undefined'];
    protected $language;
    protected $user;
    protected $db;

    function beforeRoute($f3)
    {
        $this->db = Database::mysql();
        if (!$f3->get('SESSION.AUTHENTICATION')) {
            if ($f3->get('VERB') == 'GET') {
                setcookie('target', $f3->get('REALM'), 0, '/');
            } else {
                setcookie('target', $this->url(), 0, '/');
            }
            $f3->reroute($this->url('/Login'));
        }
        $this->language = $_COOKIE['language'] ?? 'us';
        $f3->set('language', $this->language);
        $this->user = [
            'name' => $f3->get('SESSION.AUTHENTICATION'),
            'role' => $f3->get('SESSION.AUTHORIZATION')
        ];
        $f3->set('user', $this->user);
    }

    function jsonResponse($data = [])
    {
        if ($this->error['code'] === 0 && $data) {
            return json_encode(array_merge(['error' => $this->error], $data), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['error' => $this->error]);
        }
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
