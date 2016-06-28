<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

class GoodsCategoryModel extends \Think\Model {

    protected $patchValidate = true; //开启批量验证
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type 
     */
    protected $_validate     = [
        ['name', 'require', '商品分类名称不能为空'],
    ];

    
    /**
     * 获取所有的商品分类。
     * @return array
     */
    public function getList() {
        return $this->where(['status'=>['egt',0]])->order('lft')->select();
    }
    
    /**
     * 完成分类的添加，和计算左右节点和层级的功能。
     * 使用nestedsets实现
     */
    public function addCategory() {
        unset($this->data[$this->getPk()]);
        //创建ORM对象
        $orm = D('MySQL','Logic');
        //创建nestedsets对象
        $nestedsets = new \Admin\Logic\NestedSets($orm, $this->trueTableName, 'lft', 'rght', 'parent_id', 'id', 'level');
        $nestedsets->insert($this->data['parent_id'], $this->data, 'bottom');
        exit;
    }

}
