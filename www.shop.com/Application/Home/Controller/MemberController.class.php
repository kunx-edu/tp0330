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
    
    /**
     * 激活邮件.
     * @param type $email
     * @param type $register_token
     */
    public function active($email,$register_token) {
        //查询有没有一个记录,邮箱和token和传过来的一致的
        $cond = [
            'email'=>$email,
            'register_token'=>$register_token,
            'status'=>0,
        ];
        if($this->_model->where($cond)->count()){
            //修改状态
            $this->_model->where($cond)->setField('status',1);
            $this->success('激活成功',U('Index/index'));
        }else{
            $this->error('验证失败',U('Index/index'));
        }
    }
    
}
