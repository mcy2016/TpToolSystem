<?php
/**
 * Created by MCY<1991993249@qq.com>勉成翌
 * User: Administrator
 * Date: 2017/5/8
 * Time: 19:16
 */

namespace app\admin\model;

use think\Model;

class Subscribe extends Model
{

    public function subscribeToolByUjn($u_jn)
    {
        $map['u_jn'] =$u_jn;
        $map['status']=1;
        $data = $this->where($map)->select();
        if(!$data){
            $this->error='您还没有借用工具，要努力哦！';
            return false;
        }
        return $data;
    }
}