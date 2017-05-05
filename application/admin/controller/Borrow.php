<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 12:33
 */

namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Borrow extends Common
{
    public function read(){

    }

    /**
     * @return array
     */
    public function getBoUser(){
        $request = Request::instance();
        $borrowReturnModel = model('BorrowReturn');
        $toolModel = model('Tool');
        $param['u_jn']=$request->param('jobNumber');
        $dataInfo1=$borrowReturnModel->getToolByUjn(intval($param['u_jn']));
//        var_dump($data) ;
        if(!$dataInfo1){
            return resultArray(['error'=>$borrowReturnModel->getError()]);
        }
            $data=array();
        for ($i=0;$i<count($dataInfo1);$i++){
            $dataInfo2 = $toolModel->getToolByBd(intval($dataInfo1[$i]['borrow_barcode']));
            //return $dataInfo2;
            $data[]= ['tl_barcode'=>$dataInfo2[0]['tl_barcode'],
                'tl_position'=>$dataInfo2[0]['tl_position'],
                'tl_name'=>$dataInfo2[0]['tl_name'],
                'tl_pn'=>$dataInfo2[0]['tl_pn'],
                'u_name'=>$dataInfo1[$i]['u_name'],
                'borrow_admin'=>$dataInfo1[$i]['borrow_admin'],
                'u_jn'=>$dataInfo1[$i]['u_jn'],
                'borrow_no'=>$dataInfo1[$i]['borrow_no'],
                'borrow_date'=>$dataInfo1[$i]['borrow_date']
            ];
        }
        //return $borrowReturnModel->getLastsql();
        return resultArray(['data' => $data]);
    }

    public function getToolByUjn(){

    }
}