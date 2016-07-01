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
class PermissionModel extends \Think\Model{
    protected $_validate=[
        ['name','require','权限名称不能为空']
    ];

    /**
     * 获取分类列表.
     * @return type
     */
    public function getList() {
        return $this->where(['status'=>1])->order('lft')->select();
    }
    
    //使用nestedsets添加权限
    public function addPermission() {
        //创建orm
        $orm = D('MySQL','Logic');
        //创建nestedsets对象
        $nestedsets = new \Admin\Logic\NestedSets($orm, $this->getTableName(), 'lft', 'rght', 'parent_id', 'id', 'level');
        if($nestedsets->insert($this->data['parent_id'], $this->data, 'bottom') === false){
            $this->error = '添加失败';
            return false;
        }
        return true;
    }
    
    
}
