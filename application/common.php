<?php

// 应用公共文件
/**
 * 返回对象
 * @param $array 响应数据
 */
function resultArray($array)
{
    if (isset($array['data'])) {
        $array['error'] = '';
        $code = 200;
    } elseif (isset($array['error'])) {
        $code = 400;
        $array['data'] = '';
    }
    return [
        'code' => $code,
        'data' => $array['data'],
        'error' => $array['error']
    ];
}