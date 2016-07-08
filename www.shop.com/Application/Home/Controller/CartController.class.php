<?php
/**
 * Created by PhpStorm.
 * User: qingf
 * Date: 2016/7/8
 * Time: 15:28
 */

namespace Home\Controller;


use Think\Controller;

/**
 * 购物车相关逻辑的控制器.
 * Class CartController
 * @package Home\Controller
 */
class CartController extends Controller {
    public function add2car($id, $amount) {
        $userinfo = login();
        if (!$userinfo) {
            //未登录
            $key      = 'USER_SHOPPING_CAR';
            $car_list = cookie($key);
            /**
             * [
             *  'goods_id'=>amount,
             *  'goods_id'=>amount,
             * ]
             * 假设我们的需求是:
             * 如果cookie中已经有了此商品,再在详情页添加,其实是增加商品的数量
             */
            if (isset($car_list[$id])) {
                $car_list[$id] += $amount;
            } else {
                $car_list[$id] = $amount;
            }
            cookie($key, $car_list, 604800);//保存一周
        }else{
            //已登录
            //获取当前商品的数量
            $shopping_car_model = D('ShoppingCar');
            $db_amount = $shopping_car_model->getAmountByGoodsId($id);
            if($db_amount){
                //如果已经存在,就加数量
                $shopping_car_model->addAmount($id,$amount);
            }else{
                //如果不存在,就加记录
                $shopping_car_model->add2car($id,$amount);
            }
        }
        //跳转到购物车列表页面
        $this->success('添加成功',U('flow1'));

    }

    public function flow1() {
        $this->display();
    }
}