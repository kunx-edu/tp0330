<?php

namespace Admin\Controller;

/**
 * Description of RoleController
 *
 * @author qingf
 */
class RoleController extends \Think\Controller {

    /**
     * @var \Admin\Model\RoleModel 
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Role');
    }

    public function index() {
        //搜索条件
        $name = I('get.name');
        $cond = [];
        if($name){
            $cond['name'] = [
                'like','%'.$name.'%'
            ];
        }
        $this->assign($this->_model->getPageResult($cond));
        $this->display();
    }
    
    public function add() {
        if(IS_POST){
            
        }else{
            //获取所有权限
            $permission_model = D('Permission');
            $permissions = $permission_model->getList();
            //传递
            $this->assign('permissions',  json_encode($permissions));
            $this->display();
        }
    }
    
    public function edit($id) {
        $this->display();
    }
    
    public function remove($id) {
    }
}
