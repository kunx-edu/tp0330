<?php

namespace Home\Model;
class MemberModel extends \Think\Model{
    protected $patchValidate = true;
    /**
     * 1.username 必填 唯一
     * 2.password 必填 长度6-16位
     * 3.repassword 必须和password一样
     * 4.email 必填  唯一
     * 5.手机号码 必填  唯一  手机号码合法
     * 
     * 6.验证手机验证码是否合法
     * 7.验证图片验证码是否合法
     */
    protected $_validate = [
        ['username','require','用户名不能为空'],
        ['username','','用户名已存在',self::EXISTS_VALIDATE,'unique'],
        ['password','require','密码不能为空'],
        ['password','6,16','密码必须6-16位',self::EXISTS_VALIDATE,'length'],
        ['repassword','password','两次密码不一致',self::EXISTS_VALIDATE,'confirm'],
        ['email','require','邮箱不能为空'],
        ['email','email','邮箱不合法'],
        ['email','','邮箱已存在',self::EXISTS_VALIDATE,'unique'],
        ['tel','require','手机号码不能为空'],
        ['tel','/^1[34578]\d{9}$/','手机号码不合法',self::EXISTS_VALIDATE,'regex'],
        ['email','','邮箱已存在',self::EXISTS_VALIDATE,'unique'],
        ['checkcode','require','图片验证码不能为空'],
        ['checkcode','checkImgCode','图片验证码不正确',self::EXISTS_VALIDATE,'callback'],
        ['captcha','require','手机验证码不能为空'],
        ['captcha','checkTelCode','手机验证码不正确',self::EXISTS_VALIDATE,'callback'],
    ];
    
    /**
     * add_time: NOW_TIME
     * salt:随机
     */
    protected $_auto = [
        ['add_time',NOW_TIME],
        ['salt','\Org\Util\String::randString',self::MODEL_INSERT,'function'],
    ];
    
    /**
     * 验证图片验证码.
     * @param type $code
     * @return type
     */
    protected function checkImgCode($code) {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    
    /**
     * 验证手机验证码.
     * @param type $code
     * @return boolean
     */
    protected function checkTelCode($code) {
        if($code == session('reg_tel_code')){
            session('reg_tel_code',null);
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 注册
     */
    public function addMember() {
        //加盐加密
        $this->data['password']=  salt_mcrypt($this->data['password'], $this->data['salt']);
        return $this->add();
    }
}
