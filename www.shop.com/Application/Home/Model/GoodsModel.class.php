<?php
/**
 * Created by PhpStorm.
 * User: qingf
 * Date: 2016/7/7
 * Time: 14:16
 */

namespace Home\Model;


use Think\Model;

class GoodsModel extends Model{

    /**
     * 根据促销状态显示商品列表.
     * @param integer $goods_status 商品促销状态
     * @return array
     */
    public function getListByGoodsStatus($goods_status) {
        $cond = [
            'status'=>1,
            'is_on_sale'=>1,
            'goods_status & '.$goods_status,
        ];
        return $this->where($cond)->select();
    }

    /**
     * 获取商品信息.
     * @param integer $id 商品id
     */
    public function getGoodsInfo($id) {
        $row = $this->field('g.*,b.name as bname,gi.content')->alias('g')->where(['is_on_sale'=>1,'g.status'=>1,'g.id'=>$id])->join('__BRAND__ as b ON g.brand_id=b.id')->join('__GOODS_INTRO__ as gi ON gi.goods_id=g.id')->find();
        $row['galleries'] = M('GoodsGallery')->where(['goods_id'=>$id])->getField('path',true);
        return $row;
    }
}