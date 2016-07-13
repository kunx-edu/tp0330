<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of OrderInfoModel
 *
 * @author qingf
 */
class OrderInfoModel extends \Think\Model{
    public $statuses = [
        0=>'已取消',
        1=>'待支付',
        2=>'待发货',
        3=>'待收货',
        4=>'完成',
    ];
    
    public function getList() {
        return $this->order('inputtime desc')->select();
    }
}
