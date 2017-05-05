<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14
 * Time: 16:32
 */
namespace app\admin\controller;
use think\Request;
use app\common\controller\Common;

class User extends Common
{

    public function index()
    {

    }

    public function getByUjn()
    {

        $request = Request::instance();
        $userModel = model('User');
        $param['u_jn']=$request->param('jobNumber');
        $data=$userModel->getByUjn(intval($param['u_jn']));
//        var_dump($data) ;
        if(!$data){
            return resultArray(['error'=>$userModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }
}