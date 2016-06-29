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
        
    }
    
    public function add() {
        if(IS_POST){
            dump(I('post.','',false));
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
