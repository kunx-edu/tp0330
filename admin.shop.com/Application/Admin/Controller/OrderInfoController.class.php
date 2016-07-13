<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of OrderInfoController
 *
 * @author qingf
 */
class OrderInfoController extends \Think\Controller {

    /**
     * 获取所有用户的列表,分页显示.
     */
    public function index() {
        $order_info_model = D('OrderInfo');
        $rows             = $order_info_model->getList();
        $this->assign('rows', $rows);
        $this->assign('statuses', $order_info_model->statuses);
        $this->display();
    }

    public function send($id) {
        $order_info_model = D('OrderInfo');
        if ($order_info_model->where(['id' => $id])->setField('status', 3) === false) {
            $this->error(get_error($order_info_model));
        } else {
            $this->success('发货成功', U('index'));
        }
    }

    public function clearTimeOutOrder() {
            M()->startTrans();
            //获取超时订单
            $order_info_model = D('OrderInfo');
            //  inputtime+900<    now 
            //inputtime<now-900
            $order_ids        = $order_info_model->where(['intputtime' => ['lt', NOW_TIME - 900], 'status' => 1])->getField('id', true);
            if (!$order_ids) {//如果没有超时的,无需执行后续逻辑
                return true;
            }

            //修改这些订单的状态
            $order_info_model->where(['id' => ['in', $order_ids]])->setField('status', 0);
            //恢复库存
            $order_info_item_model = M('OrderInfoItem');
            $goods_list            = $order_info_item_model->where(['id' => ['in', $order_ids]])->getField('id,goods_id,amount');
            //遍历每个商品,释放库存
            $goods_model           = M('Goods');
    //        foreach($goods_list as $goods){
    //            $goods_model->where(['id'=>$goods['goods_id']])->setInc('stock',$goods['amount']);
    //        }
            //上面的方式会出现,相同id的商品执行多次写操作的问题,增加了MySQL服务器的压力
            $data = [];
            foreach ($goods_list as $goods) {
                if (isset($data[$goods['goods_id']])) {

                    $data[$goods['goods_id']] += $goods['amount'];
                } else {
                    $data[$goods['goods_id']] = $goods['amount'];
                }
            }
            foreach ($data as $goods_id => $amount) {
                $goods_model->where(['id'=>$goods_id])->setInc('stock',$amount);
            }
            M()->commit();
    }

}
