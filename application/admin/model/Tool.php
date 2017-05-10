<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 12:43
 */

namespace app\admin\model;

use think\Model;

class Tool extends Model
{
    public function getDataList()
    {
        //$data = Tool::all();
        $data = $this->select();
        if (!$data) {
            $this->error = '暂无数据';
            return false;
        }
        return $data;
    }

    /**
     * 根据工具名称查询工具
     * @param $tlName  工具名称
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public function getToolByName($tlName)
    {
        $data = $this->where('tl_name', 'like', '%' . $tlName . '%')->select();
        if (!$data) {
            $this->error = '无该工具，你真是异想天开！';
            return false;
        }
        return $data;
    }

    public function getToolByPn($tlPn)
    {
        $data = $this->where('tl_pn', $tlPn)->select();
        if (!$data) {
            $this->error = '无该工具，你真异想天开！';
            return false;
        }
        return $data;
    }

    public function getToolByBd($tlBarcode)
    {
        $data = $this->where('tl_barcode', $tlBarcode)->select();
        if (!$data) {
            $this->error = '无该工具，你真异想天开！';
            return false;
        }
        return $data;
    }

    //更新工具的预约状态
    public function updateSubscribe($id='',$value=''){
        $tool=new Tool();
        $data=$tool->where('tl_barcode','=',$id)
            ->find();
        $data->tl_issubscribe=$value;
        $data->tl_status=-10;
        $rs=$data->save();
        return $rs;
    }
}