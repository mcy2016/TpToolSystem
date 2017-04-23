<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/16
 * Time: 9:42
 */

namespace app\admin\model;

use think\Model;

class BorrowReturn extends Model
{
    protected $table = 'tl_b_return_info';

    /**
     * @return array
     */
    public function insertBorrow($borrowInfo)
    {

    }

    //根据借用人查询借用工具
    public function getToolByUjn($u_jn)
    {
        $map['u_jn'] =$u_jn;
        $map['is_return']=0;
        $data = $this->where($map)->select();
        if(!$data){
            $this->error='您还没有借用工具，要努力哦！';
            return false;
        }
        return $data;
    }
}