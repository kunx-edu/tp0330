<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of BrandController
 *
 * @author qingf
 */
class ArticleController extends \Think\Controller {

    /**
     * @var \Admin\Model\ArticleModel 
     */
    private $_model = null;

    protected function _initialize() {
        $this->_model = D('Article');
    }

    /**
     * 获取文章列表
     */
    public function index() {
        //获取文章列表
        $name = I('get.name');
        $cond = [];
        if ($name) {
            $cond['name'] = ['like', '%' . $name . '%'];
        }
        $this->assign($this->_model->getPageResult($cond));

        //获取所有的文章分类
        $article_category_model = D('ArticleCategory');
        $categories             = $article_category_model->getList();
        $this->assign('categories', $categories);
        $this->display();
    }

    /**
     * 添加文章。
     */
    public function add() {
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->addArticle() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('添加成功', U('index'));
        } else {
            //获取分类列表
            $article_category_model = D('ArticleCategory');
            $categories             = $article_category_model->getList();
            $this->assign('categories', $categories);
            $this->display();
        }
    }

    /**
     * 编辑文章。
     * @param type $id
     */
    public function edit($id) {
        if (IS_POST) {
            //收集数据
            if ($this->_model->create() === false) {
                $this->error(get_error($this->_model));
            }
            if ($this->_model->saveArticle() === false) {
                $this->error(get_error($this->_model));
            }
            $this->success('修改成功', U('index'));
        } else {
            //展示数据
            $row = $this->_model->getArticleInfo($id);
            $this->assign('row', $row);

            //获取分类列表
            $article_category_model = D('ArticleCategory');
            $categories             = $article_category_model->getList();
            $this->assign('categories', $categories);
            $this->display('add');
        }
    }

    public function remove($id) {
        if ($this->_model->deleteArticle($id) === false) {
            $this->error(get_error($this->_model));
        } else {
            $this->success('删除成功', U('index'));
        }
    }

}
