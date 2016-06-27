<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

class BrandModel extends \Think\Model {

    protected $patchValidate = true; //开启批量验证
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type 
     */
    protected $_validate     = [
        ['name', 'require', '品牌名称不能为空'],
        ['name', '', '品牌已存在', self::EXISTS_VALIDATE, 'unique'],
        ['status', '0,1', '品牌状态不合法', self::EXISTS_VALIDATE, 'in'],
        ['sort', 'number', '排序必须为数字'],
    ];

    /**
     * 获取分页数据和分页代码。
     * @param array $cond 查询条件。
     */
    public function getPageResult(array $cond = []) {
        $cond         = array_merge(['status' => ['egt', 0]],$cond);
        //获取分页代码
        //获取分页配置
        $page_setting = C('PAGE_SETTING');
        //获取总行数
        $count        = $this->where($cond)->count();
        $page         = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        //更改page样式
        $page->setConfig('theme', $page_setting['PAGE_THEME']);
        $page_html    = $page->show();
        //获取分页数据
        $rows         = $this->where($cond)->page(I('get.p', 1), $page_setting['PAGE_SIZE'])->select();
        return compact(['rows', 'page_html']);

    }

}
