<?php
/**
 * Created by MCY<1991993249@qq.com>勉成翌
 * User: Administrator
 * Date: 2017/5/8
 * Time: 19:15
 */

namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Subscribe extends Common
{
    public function subscribeBorrow()
    {
        $request = Request::instance();
        $param = $request->param();
        $subscribeModel=model('Subscribe');
        $borrow_date = time();
        //date('Y-m-d H:i:s', 1492268952);//时间戳格式化
        $map['u_jn'] = intval($request->param('uJn'));
        $map['borrow_barcode'] = intval($request->param('tlBarcodeList'));
        //$map['borrow_no']=$request->param('borrowNo');
        $borrow_no1 = date('YmdHis', $borrow_date);//当前日期
        $map['status'] = intval($request->param('subscribe'));
        $map['borrow_date'] = $borrow_date;
        $n = 002;
        $map['borrow_no'] = $borrow_no1 . $request->param('uJn') . $n;
        $map['u_name'] = $request->param('uName');
        //var_dump($map);exit();
        $data = $subscribeModel->save($map);
//        var_dump($data);
        if (!$data) {
            resultArray(['error' => '插入数据失败咯！！']);
        }
        $toolModel=model('Tool');
        $rs=$toolModel->updateSubscribe($map['borrow_barcode'],1);
        return resultArray(['data' => $map['borrow_no']]);
    }

    public function getBoUser(){
        $request = Request::instance();
        $subscribeModel = model('Subscribe');
        $toolModel = model('Tool');
        $param['u_jn']=$request->param('jobNumber');
        //var_dump($param['u_jn']);exit();
        $dataInfo1=$subscribeModel->subscribeToolByUjn(intval($param['u_jn']));

        if(!$dataInfo1){
            return resultArray(['error'=>$subscribeModel->getError()]);
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
                //'borrow_admin'=>$dataInfo1[$i]['borrow_admin'],
                'u_jn'=>$dataInfo1[$i]['u_jn'],
                'borrow_no'=>$dataInfo1[$i]['borrow_no'],
                'borrow_date'=>$dataInfo1[$i]['borrow_date']
            ];
        }
        //return $borrowReturnModel->getLastsql();
        return resultArray(['data' => $data]);
    }

}