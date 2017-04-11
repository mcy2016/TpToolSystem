<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 12:29
 */

namespace app\common\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{
    public $param;
    // 控制器初始化方法
    public function _initialize()
    {
        parent::_initialize();
        /*防止跨域*/
        header('Access-Control-Allow-Origin: http://localhost:8080');//.$_SERVER['HTTP_ORIGIN']
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        $param =  Request::instance()->param();  //获取请求参数
        $this->param = $param;
    }
}