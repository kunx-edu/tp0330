<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of AdminController
 *
 * @author qingf
 */
class AdminController extends \Think\Controller {

    /**
     * @var \Admin\Model\AdminModel
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Admin');
    }

    public function index() {
        //获取管理员列表
        $name = I('get.name');
        $cond = [];
        if ($name) {
            $cond['username'] = ['like', '%' . $name . '%'];
        }
        $this->assign($this->_model->getPageResult($cond));
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addAdmin() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    public function edit($id) {
        if(IS_POST){
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->saveAdmin($id) === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        }else{
            //获取管理员信息,包括角色
            $row = $this->_model->getAdminInfo($id);
            $this->assign('row',$row);
            //获取所有角色列表
            $this->_before_view();
            $this->display('add');
        }
    }

    /**
     * 删除管理员,并且删除管理员和角色关联关系.
     * @param type $id
     */
    public function remove($id) {
        if($this->_model->deleteAdmin($id)===false){
            $this->error(get_error($this->_model));
        }
        $this->success('删除成功', U('index'));
        
    }

    private function _before_view() {
        //获取所有的角色列表
        $role_model = D('Role');
        //传递数据
        $roles      = $role_model->getList();
        $this->assign('roles', json_encode($roles));
    }
    
    /**
     * 后台管理员登陆和验证
     */
    public function login() {
        if(IS_POST){
            if ($this->_model->create('','login') === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->login() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('登陆成功', U('Index/index'));
        }else{
            $this->display();
        }
    }

}
