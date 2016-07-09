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

        $mete_titles = [
            'reg'=>'用户注册',
            'login'=>'用户登陆',
        ];
        $meta_title = (isset($mete_titles[ACTION_NAME])?$mete_titles[ACTION_NAME]:'用户登陆');
        $this->assign('meta_title',$meta_title);

    }
    
    /**
     * 注册.
     */
    public function reg() {
        if(IS_POST){
            if($this->_model->create('','reg') === false){
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
     * 用户登陆
     * 获取和保存用户信息、自动将购物车cookie数据保存到MySQL中
     */
    public function login() {
        if(IS_POST){
            if($this->_model->create() === false){
                $this->error(get_error($this->_model));
            }
            if($this->_model->login() === false){
                $this->error(get_error($this->_model));
            }
            $url = cookie('__FORWARD__');
            cookie('__FORWARD__',null);
            if(!$url){
                $url = U('Index/index');
            }
            //完成购物车的数据保存到MySQL中
            $this->success('登陆成功',$url);

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

    /**
     * 检查注册信息是否已经被占用.
     * 检查用户名,邮箱,手机号码.
     */
    public function checkByParam() {
        $cond = I('get.');
        if($this->_model->where($cond)->count()){
            $this->ajaxReturn(false);
        }else{
            $this->ajaxReturn(true);
        }
    }


    public function logout() {
        session(null);
        cookie(null);
        $this->success('退出成功',U('Index/index'));
    }

    /**
     * 获取用户名.
     */
    public function userinfo() {
        $userinfo = login();
        if($userinfo){
            $this->ajaxReturn($userinfo['username']);
        }else{
            $this->ajaxReturn(false);
        }
    }
}
