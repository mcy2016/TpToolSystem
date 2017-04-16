<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14
 * Time: 16:46
 */

namespace app\admin\model;

use think\Model;

class User extends Model
{
    /**
     * 根据用户工号查询用户
     * @param $u_jn 用户工号
     */
    public function getByUjn($u_jn){
        $map['u_jn'] =$u_jn;
        $map['u_status']=1;
        $data = $this->where($map)->select();
        if(!$data){
            $this->error='你想翻天？你的信息还没进系统';
            return false;
        }
        return $data;
    }
}