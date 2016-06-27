<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

class ArticleModel extends \Think\Model {

    protected $patchValidate = true; //开启批量验证
    /**
     * name 必填，不能重复
     * status 可选值0-1
     * sort 必须是数字
     * @var type 
     */
    protected $_validate     = [
        ['name', 'require', '文章名称不能为空'],
        ['article_category_id', 'require', '文章分类不合法'],
        ['status', '0,1', '文章状态不合法', self::EXISTS_VALIDATE, 'in'],
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
    /**
     * 使用关联查询获取分页数据和分页代码。
     * @param array $cond 查询条件。
     */
    public function getPageResult2(array $cond = []) {
        $cond         = array_merge(['a.status' => ['egt', 0]],$cond);
        //获取分页代码
        //获取分页配置
        $page_setting = C('PAGE_SETTING');
        //获取总行数
        $count        = $this->alias('a')->where($cond)->count();
        $page         = new \Think\Page($count, $page_setting['PAGE_SIZE']);
        //更改page样式
        $page->setConfig('theme', $page_setting['PAGE_THEME']);
        $page_html    = $page->show();
        //获取分页数据
        $rows         = $this->alias('a')->field('a.*,ac.name as cname')->where($cond)->join('__ARTICLE_CATEGORY__ as ac ON ac.id=a.article_category_id')->page(I('get.p', 1), $page_setting['PAGE_SIZE'])->select();
        return compact(['rows', 'page_html']);

    }

    /**
     * 新建文章
     * @return boolean
     */
    public function addArticle() {
        //保存文章基本信息
        if(($article_id = $this->add())===false){
            return false;
        }
        //保存文章内容
        $data = [
            'article_id'=>$article_id,
            'content'=>I('post.content'),
        ];
        if(M('ArticleContent')->add($data) === false){
            $this->error = '保存详细内容失败';
            return false;
        }
        return true;
    }
    /**
     * 保存文章
     * @return boolean
     */
    public function saveArticle() {
        $article_id = $this->data['id'];
        //保存文章基本信息
        if($this->save()===false){
            return false;
        }
        //保存文章内容
        $data = [
            'article_id'=>$article_id,
            'content'=>I('post.content'),
        ];
        if(M('ArticleContent')->save($data) === false){
            $this->error = '保存详细内容失败';
            return false;
        }
        return true;
    }
    
    /**
     * 获取文章完整内容。
     * @param integer $id
     * @return type
     */
    public function getArticleInfo($id) {
        return $this->join('__ARTICLE_CONTENT__ as ac on ac.article_id=__ARTICLE__.id')->find($id);
    }
    
    /**
     * 删除文章，包括详细信息。
     * @param integer $id
     */
    public function deleteArticle($id) {
        //删除基本信息
        if($this->delete($id) === false){
            return false;
        }
        //删除详细内容
        if(M('ArticleContent')->delete($id) === false){
            $this->error = '删除失败';
            return false;
        }
        return true;
    }
}
