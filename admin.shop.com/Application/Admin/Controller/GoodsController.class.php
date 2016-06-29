<?php
namespace Admin\Controller;

class GoodsController extends \Think\Controller{
    
    /**
     * @var \Admin\Model\GoodsModel
     */
    private $_model = null;


    protected function _initialize() {
        $this->_model = D('Goods');
    }
    
    public function index() {
        //1.获取商品列表
        $this->assign($this->_model->getPageResult());
        $this->display();
    }
    
    public function add() {
        if(IS_POST){
            //收集数据
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }
            //添加商品
            if($this->_model->addGoods() === false){
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功',U('index'));
        }else{
            //1.获取所有的商品分类,使用ztree展示,所以转换成json
            $goods_category_model = D('GoodsCategory');
            $goods_categories = $goods_category_model->getList();
            $this->assign('goods_categories', json_encode($goods_categories));
            
            //2.获取所有的品牌列表
            $brand_model = D('Brand');
            $brands = $brand_model->getList();
            $this->assign('brands', $brands);
            
            //3.获取所有的供货商列表
            $supplier_model = D('Supplier');
            $suppliers = $supplier_model->getList();
            $this->assign('suppliers', $suppliers);
            $this->display();
        }
    }
    
    public function edit($id) {
        
    }
    
    public function remove($id) {
        
    }
}
