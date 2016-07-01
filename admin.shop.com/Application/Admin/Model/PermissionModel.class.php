<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of PermissionModel
 *
 * @author qingf
 */
class PermissionModel extends \Think\Model {

    protected $_validate = [
        ['name', 'require', '权限名称不能为空']
    ];

    /**
     * 获取分类列表.
     * @return type
     */
    public function getList() {
        return $this->where(['status' => 1])->order('lft')->select();
    }

    //使用nestedsets添加权限
    public function addPermission() {
        unset($this->data[$this->getPk()]);
        //创建orm
        $orm        = D('MySQL', 'Logic');
        //创建nestedsets对象
        $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if ($nestedsets->insert($this->data['parent_id'], $this->data, 'bottom') === false) {
            $this->error = '添加失败';
            return false;
        }
        return true;
    }

    /**
     * 编辑权限.
     * @return boolean
     */
    public function savePermission() {
        //判断是否修改了父级权限
        $parent_id = $this->getFieldById($this->data['id'], 'parent_id');
        if ($parent_id != $this->data['parent_id']) {
            //创建orm
            $orm        = D('MySQL', 'Logic');
            //创建nestedsets对象
            $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nestedsets->moveUnder($this->data['id'], $this->data['parent_id'], 'bottom') === false) {
                $this->error = '不能将分类移动到自身或后代分类中';
                return false;
            }
        }
        //保存基本数据
        return $this->save();
    }

    /**
     * 删除权限及其后代权限
     * 如果权限已经不存在,那么角色的关联也应当销毁,销毁的当然也是包括后代的.
     * @param type $id
     * @return boolean
     */
    public function deletePermission($id) {
        $this->startTrans();
        //获取后代权限
        $permission_info = $this->field('lft,rght')->find($id);
        $cond = [
            'lft'=>['egt',$permission_info['lft']],
            'rght'=>['elt',$permission_info['rght']],
        ];
        $permission_ids = $this->where($cond)->getField('id',true);
        //删除角色-权限中间表的相关权限记录
        $role_permission_model = M('RolePermission');
        if($role_permission_model->where(['permission_id'=>['in',$permission_ids]])->delete()===false){
            $this->error = '删除角色-权限关联失败';
            $this->rollback();
            return false;
        }
        //创建orm
        $orm        = D('MySQL', 'Logic');
        //创建nestedsets对象
        $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        
        if ($nestedsets->delete($id) === false) {
            $this->error = '删除失败';
            $this->rollback();
            return false;
        } else {
            $this->commit();
            return true;
        }
    }

}
