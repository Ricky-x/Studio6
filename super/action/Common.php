<?php


function sendSuccess($msg = '', $data = [], $code = 200)
{
    $result = [
        'code' => $code,
        'msg'  => $msg,
        'time' => time(),
        'data' => $data,
    ];
    return json_encode($result, JSON_UNESCAPED_UNICODE);
}


