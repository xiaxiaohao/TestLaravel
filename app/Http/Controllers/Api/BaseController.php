<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    use Helpers;

    protected function msg($errcode = 0, $msg = '', $data = [])
    {
        header('Content-Type:application/json; charset=utf-8');
        $r = [
            'errcode' => $errcode,
            'msg' => $msg,
            'data' => $data
        ];
        exit(json_encode($r));
    }

    protected function success($msg = '', $data = [])
    {
        if (is_string($msg)) {
            $this->msg(0, $msg, $data);
        } else {
            $this->msg(0, '', $msg);
        }
    }

    protected function error($msg = '', $errcode = -1)
    {
        $this->msg($errcode, $msg);
    }
}