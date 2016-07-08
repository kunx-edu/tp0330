<?php
/**
 * Created by PhpStorm.
 * User: qingf
 * Date: 2016/7/8
 * Time: 15:36
 */

namespace Home\Model;


use Think\Model;

class ShoppingCarModel extends Model{

    /**
     * 获取购物车中指定商品的数量.
     * @param integer $goods_id 商品id.
     * @return integer
     */
    public function getAmountByGoodsId($goods_id) {
        $userinfo = login();
        $cond = [
            'member_id'=>$userinfo['id'],
            'goods_id'=>$goods_id,
        ];
        return $this->where($cond)->getField('amount');
    }

    /**
     * 将数据表中,指定的商品购买数量增加.
     * @param integer $goods_id 商品id.
     * @param integer $amount 商品的数量.
     * @return bool
     */
    public function addAmount($goods_id,$amount) {
        $userinfo = login();
        $cond = [
            'member_id'=>$userinfo['id'],
            'goods_id'=>$goods_id,
        ];
        return $this->where($cond)->setInc('amount',$amount);
    }

    /**
     * 将商品添加到数据库中.
     * @param integer $goods_id 商品id.
     * @param integer $amount 商品的数量.
     * @return bool
     */
    public function add2car($goods_id,$amount) {
        $userinfo = login();
        $data = [
            'member_id'=>$userinfo['id'],
            'goods_id'=>$goods_id,
            'amount'=>$amount,
        ];
        return $this->add($data);
    }
}