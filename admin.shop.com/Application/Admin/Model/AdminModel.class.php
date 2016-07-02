<?php

namespace Admin\Model;

class AdminModel extends \Think\Model{
    protected $patchValidate = true;
    
    /**
     * 1.username必填 唯一
     * 2.password必填 长度6-16位
     * 3.repassword 和password一致
     * 4.email 必填 唯一
     * @var type 
     */
    protected $_validate = [
        ['username','require','用户名不能为空'],
        ['username','','用户名已被占用',self::EXISTS_VALIDATE,'unique'],
        ['password','require','密码不能为空',self::EXISTS_VALIDATE],
        ['password','6,16','密码长度不合法',self::EXISTS_VALIDATE,'length'],
        ['repassword','password','两次密码不一致',self::EXISTS_VALIDATE,'confirm'],
        ['email','require','邮箱不能为空'],
        ['email','email','邮箱格式不合法',self::EXISTS_VALIDATE],
        ['email','','邮箱已被占用',self::EXISTS_VALIDATE,'unique'],
    ];
    
    /**
     * 1. add_time 当前时间
     * 2. 盐 自动生成随机盐
     * @var type 
     */
    protected $_auto = [
        ['add_time',NOW_TIME],
        ['salt','\Org\Util\String::randString',self::MODEL_INSERT,'function']
    ];
    
    /**
     * 获取分页数据
     * @param array $cond
     * @return type
     */
    public function getPageResult(array $cond=[]) {
        //查询条件
        $cond = array_merge(['status'=>1],$cond);
        //总行数
        $count = $this->where($cond)->count();
        //获取配置
        $page_setting = C('PAGE_SETTING');
        //工具类对象
        $page = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        //设置主题
        $page->setConfig('theme', $page_setting['PAGE_THEME']);
        //获取分页代码
        $page_html = $page->show();
        //获取分页数据
        $rows = $this->where($cond)->page(I('get.p',1),$page_setting['PAGE_SIZE'])->select();
        return compact('rows', 'page_html');
    }
    
    /**
     * 创建管理员.
     * @return type
     */
    public function addAdmin() {
        $this->startTrans();
        //加盐加密
        $this->data['password'] = salt_mcrypt($this->data['password'], $this->data['salt']);
        if(($admin_id = $this->add())===false){
            $this->rollback();
            return false;
        }
        //保存管理员角色关联
        $admin_role_model = M('AdminRole');
        $data = [];
        $role_ids = I('post.role_id');
        foreach($role_ids as $role_id){
            $data[] = [
                'admin_id'=>$admin_id,
                'role_id'=>$role_id,
            ];
        }
        if($data){
            if($admin_role_model->addAll($data)===false){
                $this->error = '保存角色关联失败';
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
    
    public function getAdminInfo($id) {
        $row = $this->find($id);
        $admin_role_model = M('AdminRole');
        $row['role_ids'] = json_encode($admin_role_model->where(['admin_id'=>$id])->getField('role_id',true));
        return $row;
    }
    
    /**
     * 修改管理员.
     * @param integer $id 管理员id.
     * @return boolean
     */
    public function saveAdmin($id) {
        $this->startTrans();
        //保存管理员角色关联
        $admin_role_model = M('AdminRole');
        //删除关联的角色
        if($admin_role_model->where(['admin_id'=>$id])->delete()===false){
            $this->error = '删除原有的角色失败';
            $this->rollback();
            return false;
        }
        $data = [];
        $role_ids = I('post.role_id');
        foreach($role_ids as $role_id){
            $data[] = [
                'admin_id'=>$id,
                'role_id'=>$role_id,
            ];
        }
        if($data){
            if($admin_role_model->addAll($data)===false){
                $this->error = '保存角色关联失败';
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
    
    /**
     * 删除管理员,同时删除角色关联.
     * @param integer $id 管理员id
     * @return boolean
     */
    public function deleteAdmin($id) {
        $this->startTrans();
        //1.删除admin中的管理员记录
        if($this->delete($id)===false){
            $this->rollback();
            return false;
        }
        //2.删除admin和role的关联关系
        $admin_role_model = M('AdminRole');
        //删除关联的角色
        if($admin_role_model->where(['admin_id'=>$id])->delete()===false){
            $this->error = '删除角色关联失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
}
