<?php
/**
 * Created by IntelliJ IDEA.
 * User: jibo
 * Date: 2017/5/9
 * Time: 14:19
 */

namespace app\system;


use app\common\AppBase;

class SysBase extends AppBase
{
    function beforeRoute($f3)
    {
        parent::beforeRoute($f3);
        if ($this->user['role'] != 'administrator') {
            $f3->reroute($this->url('/'));
        }
    }
}