<?php

namespace Admin\Controller;

class PermissionController extends \Think\Controller {

    /**
     * @var \Admin\Model\PermissionModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Permission');
    }

    public function index() {
        //获取所有的权限列表
        $rows = $this->_model->getList();
        $this->assign('rows', $rows);
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            //保存数据
            if ($this->_model->addPermission() === false) {
                $this->error(get_error($this->_model));
            }

            //跳转
            $this->success('添加成功', U('index'));
        } else {
            //准备父级权限,也就是查出所有的权限列表
            $this->_before_view();
            $this->display();
        }
    }

    public function edit($id) {
        if(IS_POST){
            
        }else{
            //获取数据
            $row = $this->_model->find($id);
            //传递
            $this->assign('row',$row);
            //全部权限列表,json字符串,给ztree使用
            $this->_before_view();
            $this->display('add');
        }
    }

    public function remove($id) {
        $this->display();
    }

    private function _before_view() {
        $permissions = $this->_model->getList();
        array_unshift($permissions, ['id' => 0, 'name' => '顶级权限', 'parent_id' => null]);
        $this->assign('permissions', json_encode($permissions));
    }

}
