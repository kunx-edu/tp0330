<?php
/**
 * Created by PhpStorm.
 * User: qingf
 * Date: 2016/7/11
 * Time: 15:34
 */

namespace Admin\Model;


use Think\Model;

class MemberLevelModel extends Model{

    /**
     * 获取所有可用的会员等级
     * @return mixed
     */
    public function getList() {
        return $this->where(['status'=>1])->order('sort')->select();
    }
}