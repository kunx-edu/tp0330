<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of BrandController
 *
 * @author qingf
 */
class BrandController extends \Think\Controller {

    /**
     * @var \Admin\Model\BrandModel 
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Brand');
    }

    public function index() {
        //获取品牌列表
        $name = I('get.name');
        $cond = [];
        if ($name) {
            $cond['name'] = ['like', '%' . $name . '%'];
        }
        $this->assign($this->_model->getPageResult($cond));
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            //收集数据
            if($this->_model->create()===false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->add() === false){
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功',U('index'));
        } else {
            $this->display();
        }
    }

    public function edit($id) {
        if (IS_POST) {
            //收集数据
            if($this->_model->create()===false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->save() === false){
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功',U('index'));
        } else {
            //展示数据
            $row = $this->_model->find($id);
            $this->assign('row', $row);
            $this->display('add');
        }
    }

    public function remove($id) {
        $data = [
            'name'=>['exp','concat(name,"_del")'],
            'status'=>-1,
            'id'=>$id,
        ];
        if($this->_model->data($data)->save()===false){
            $this->error(get_error($this->_model));
        }else{
            $this->success('删除成功',U('index'));
        }
    }

}
