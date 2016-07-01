<?php

namespace Admin\Controller;

class GoodsController extends \Think\Controller {

    /**
     * @var \Admin\Model\GoodsModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Goods');
    }

    public function index() {
        //接收查询条件,进行条件拼接
        //商品名字
        $name = I('get.name');
        $cond = [];
        if ($name) {
            $cond['name'] = ['like', '%' . $name . '%'];
        }
        
        //分类
        $goods_category_id = I('get.goods_category_id');
        if($goods_category_id){
            $cond['goods_category_id'] = $goods_category_id;
            //找到选中分类的左右节点
            //lft>=$lft  and rght<=$rght
//            $cond['goods_category_id'] = [];
        }
        
        //品牌
        $brand_id = I('get.brand_id');
        if($brand_id){
            $cond['brand_id'] = $brand_id;
        }
        
        //促销状态
        $goods_status = I('get.goods_status');
        if($goods_status){
            $cond[] = 'goods_status & '.$goods_status;
//            $cond['goods_status'] = 'goods_status & '.$goods_status;//goods_status=goods_status&1
//            $cond['goods_status'] = ['exp','&4'];
        }

        //是否促销
        $is_on_sale = I('get.is_on_sale');
        if(strlen($is_on_sale)){
            $cond['is_on_sale'] = $is_on_sale;
        }


        //1.获取商品列表
        $this->assign($this->_model->getPageResult($cond));

        //取出商品分类
        //1.获取所有的商品分类,使用ztree展示,所以转换成json
        $goods_category_model = D('GoodsCategory');
        $goods_categories     = $goods_category_model->getList();
        $this->assign('goods_categories', $goods_categories);

        //2.获取所有的品牌列表
        $brand_model = D('Brand');
        $brands      = $brand_model->getList();
        $this->assign('brands', $brands);

        //3.获取促销状态
        $goods_statuses = [
            ['id' => 1, 'name' => '精品',],
            ['id' => 2, 'name' => '新品',],
            ['id' => 4, 'name' => '热销',],
        ];
        $this->assign('goods_statuses', $goods_statuses);
        $is_on_sales    = [
            ['id' => 1, 'name' => '上架',],
            ['id' => 0, 'name' => '下架',],
        ];
        $this->assign('is_on_sales', $is_on_sales);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            //添加商品
            if ($this->_model->addGoods() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            //修改商品
            if ($this->_model->saveGoods() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            //1.获取数据
            $row = $this->_model->getGoodsInfo($id);
            //2.传递数据
            $this->assign('row', $row);
            $this->_before_view();
            $this->display('add');
        }
    }

    public function remove($id) {
        
    }

    private function _before_view() {
        //1.获取所有的商品分类,使用ztree展示,所以转换成json
        $goods_category_model = D('GoodsCategory');
        $goods_categories     = $goods_category_model->getList();
        $this->assign('goods_categories', json_encode($goods_categories));

        //2.获取所有的品牌列表
        $brand_model = D('Brand');
        $brands      = $brand_model->getList();
        $this->assign('brands', $brands);

        //3.获取所有的供货商列表
        $supplier_model = D('Supplier');
        $suppliers      = $supplier_model->getList();
        $this->assign('suppliers', $suppliers);
    }

    /**
     * 移除相册表中的记录.
     * @param type $id
     */
    public function removeGallery($id) {
        $goods_gallery_model = M('GoodsGallery');
        if ($goods_gallery_model->delete($id) === false) {
            $this->error('删除失败');
        } else {
            $this->success('删除成功');
        }
    }

}
