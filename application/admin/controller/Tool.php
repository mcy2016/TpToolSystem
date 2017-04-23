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
    public function index()
    {
        $toolModel = model("Tool");
        $data = $toolModel->getDataList();
        if (!$data) {
            return resultArray(['error' => $toolModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }

    public function getByName()
    {
        $request = Request::instance();
        $toolModel = model("Tool");
        $param['keywords'] = $request->param('keywords');
        $param['queryMethod'] = $request->param('queryMethod');
        if ($param['queryMethod'] == 'byname') {
            if ($param['keywords'] == null) {
                $data = $toolModel->getDataList();
                return resultArray(['data' => $data]);
            }
            $tlName = $param['keywords'];
            $data = $toolModel->getToolByName($tlName);
            if (!$data) {
                return resultArray(['error' => $toolModel->getError()]);
            }
            return resultArray(['data' => $data]);
        }
        if ($param['queryMethod'] == 'bypn') {
            if ($param['keywords'] == null) {
                $data = $toolModel->getDataList();
                return resultArray(['data' => $data]);
            }
            $tlPn = $param['keywords'];
            $data = $toolModel->getToolByPn($tlPn);
            if (!$data) {
                return resultArray(['error' => $toolModel->getError()]);
            }
            return resultArray(['data' => $data]);
        }
        //return resultArray(['data' => $data]);
    }

    /**根据工具条码号查询工具
     * @return array
     */
    public function getToolByBd()
    {
        $request = Request::instance();
        $toolModel = model("Tool");
        $param['tl_barcode'] = $request->param('tiaoma');
        $data = $toolModel->getToolByBd($param['tl_barcode']);
        if (!$data) {
            return resultArray(['error' => $toolModel->getError()]);
        }
        return resultArray(['data' => $data]);
    }

    /**
     * 把借用的工具插入到tl_borrow表
     */
    public function insertBorrow()
    {
        $request = Request::instance();
        $borrowModel = model('Borrow');
        $borrowReturnModel = model('BorrowReturn');
        $toolModel = model("Tool");
        $borrow_date = time();
        //date('Y-m-d H:i:s', 1492268952);//时间戳格式化
        $param = $request->param();
        //插入tl_borrow_return表
        $map['u_jn'] = intval($request->param('uJn'));
        $map['borrow_barcode'] = $request->param('tlBarcodeList');
        //$map['borrow_no']=$request->param('borrowNo');
        $borrow_no1 = date('YmdHis', $borrow_date);//当前日期
        $map['is_return'] = intval($request->param('isReturn'));
        $map['borrow_date'] = $borrow_date;
        $n = 002;
        $map['borrow_no'] = $borrow_no1 . $request->param('uJn') . $n;
        $map['u_name'] = $request->param('uName');
        //var_dump($map);exit();
        $dataMain = $borrowModel->save($map);
        if (!$dataMain) {
            resultArray(['error' => '插入数据失败咯！！']);
        }
        //插入tl_b_return_info表
        $map['borrow_admin'] = '刘某';
        $borrowBarcodes = explode(",", $map['borrow_barcode']);
        $borcodesCount = count($borrowBarcodes);
        //var_dump($borrowBarcodes[1]);exit();
        $list = array();
        for ($i = 0; $i < $borcodesCount; $i++) {
            $map['borrow_barcode'] = $borrowBarcodes[$i];
            $list[] = ['u_jn' => $map['u_jn'], 'borrow_barcode' => $borrowBarcodes[$i], 'is_return' => $map['is_return'], 'borrow_date' => $map['borrow_date'], 'borrow_no' => $map['borrow_no'], 'u_name' => $map['u_name'], 'borrow_admin' => $map['borrow_admin']];
            $res = $toolModel->where('tl_barcode', $borrowBarcodes[$i])
                ->find();
            $result = $toolModel->where('tl_id', $res['tl_id'])->update(['tl_status' => '0']);
            //return $res;
        }
        //return $updatelists;
        $data = $borrowReturnModel->saveAll($list, false);

        if (!$data) {
            resultArray(['error' => '插不进去哟！']);
        }
        return resultArray(['data' => $map['borrow_no']]);
        //echo $borrowModel->getLastsql();
    }


    public function returnTool()
    {
        $request = Request::instance();
        $borrowReturnModel = model('BorrowReturn');
        $toolModel = model("Tool");
        $map['return_ujn'] = $request->param('reUjn');
        $map['re_barcodes'] = $request->param('barcodes');
        $date = time();//当前日期
        $returnBarcodes = explode(",", $map['re_barcodes']);
        $returnBarcodesCount = count($returnBarcodes);
        $list = array();
        for ($i = 0; $i < $returnBarcodesCount; $i++) {
            $map['borrow_barcode'] = $returnBarcodes[$i];

            $res = $toolModel->where('tl_barcode', intval($map['borrow_barcode']))
                ->update(['tl_status' => '1']);
            if (!$res) {
                return resultArray(['error' => '插入主表tool失败']);
            }
            $result = $borrowReturnModel->where('borrow_barcode', $map['borrow_barcode'])
                ->update(['is_return' => '1', 'return_admin' => 999,'return_ujn'=>$map['return_ujn'],'return_date'=>$date]);
//            return $borrowReturnModel->getLastSql();
//            return $result;exit();
            if (!$result) {
                return resultArray(['error' => '插入tl_b_return_info表失败']);
            }

        }
        return resultArray(['data' => '归还成功']);

    }

    public function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
}