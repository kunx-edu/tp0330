<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of MemberController
 *
 * @author qingf
 */
class MemberController extends \Think\Controller{
    /**
     * @var \Home\Model\MemberModel
     */
    private $_model = null;
    protected function _initialize() {
        $this->_model=D('Member');
    }
    
    /**
     * 注册.
     */
    public function reg() {
        if(IS_POST){
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->addMember() === false){
                $this->error(get_error($this->_model));
            }
            $this->success('注册成功',U('index'));
        }else{
            $this->display();
        }
    }
    
    
}
