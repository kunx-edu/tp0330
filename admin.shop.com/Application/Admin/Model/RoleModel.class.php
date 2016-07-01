<?php

namespace Admin\Model;

class RoleModel extends \Think\Model{
    
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
    
    public function addRole() {
        $this->startTrans();
        //1.保存基本信息
        if(($role_id = $this->add())===false){
            $this->rollback();
            return false;
        }
        
        //2.保存关联的权限
        $permission_ids = I('post.permission_id');
        $data = [];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'role_id'=>$role_id,
                'permission_id'=>$permission_id,
            ];
        }
        if($data){
            $role_permission_model = M('RolePermission');
            if($role_permission_model->addAll($data) ===false){
                $this->error = '保存权限失败';
                $this->rollback();
                return false;
            }
        }
        
        $this->commit();
        return true;
    }
    
    public function getPermissionInfo($id) {
        //1.获取基本信息
        $row = $this->find($id);
        //2.获取关联权限
        $role_permission_model = M('RolePermission');
        $row['permission_ids'] = json_encode($role_permission_model->where(['role_id'=>$id])->getField('permission_id',true));
        return $row;
    }
    
    
    public function saveRole() {
        $this->startTrans();
        $role_id = $this->data['id'];
        //保存基本信息
        if ($this->save() === false){
            $this->rollback();
            return false;
        }
        //删除原有的
        $role_permission_model = M('RolePermission');
        if($role_permission_model->where(['role_id'=>$role_id])->delete()===false){
            $this->error = '删除历史权限失败';
            $this->rollback();
            return false;
        }
        //保存关联的权限
        $permission_ids = I('post.permission_id');
        $data = [];
        foreach($permission_ids as $permission_id){
            $data[] = [
                'role_id'=>$role_id,
                'permission_id'=>$permission_id,
            ];
        }
        if($data){
            if($role_permission_model->addAll($data) ===false){
                $this->error = '保存权限失败';
                $this->rollback();
                return false;
            }
        }
        $this->commit();
        return true;
    }
}
