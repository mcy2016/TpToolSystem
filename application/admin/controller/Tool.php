<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 12:35
 */

namespace app\admin\controller;
use think\Request;
use app\common\controller\Common;

class Tool extends Common
{
    public function index(){
        $toolModel = model("Tool");
        $data = $toolModel->getDataList();
       if(!$data){
            return resultArray(['error' => $toolModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }

    public function getByName(){
        $request = Request::instance();
        $toolModel =model("Tool");
        $param['keywords']=$request->param('keywords');
        $param['queryMethod']=$request->param('queryMethod');
        if($param['queryMethod']=='byname'){
            if($param['keywords']==null){
                $data = $toolModel->getDataList();
                return resultArray(['data' => $data]);
            }
            $tlName = $param['keywords'];
            $data=$toolModel->getToolByName($tlName);
            if(!$data){
                return resultArray(['error'=>$toolModel->getError()]);
            }
            return resultArray(['data'=>$data]);
        }
        if($param['queryMethod']=='bypn') {
            if($param['keywords']==null){
                $data = $toolModel->getDataList();
                return resultArray(['data' => $data]);
            }
            $tlPn = $param['keywords'];
            $data=$toolModel->getToolByPn($tlPn);
            if(!$data){
                return resultArray(['error'=>$toolModel->getError()]);
            }
            return resultArray(['data'=>$data]);
        }
        //return resultArray(['data' => $data]);
    }
    public function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key=>$value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
}