<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Logic;

/**
 * Description of MySQLLogic
 *
 * @author qingf
 */
class MySQLLogic implements DbMysql {

    public function connect() {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    public function disconnect() {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    public function free($result) {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    public function getAll($sql, array $args = array()) {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    public function getAssoc($sql, array $args = array()) {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    public function getCol($sql, array $args = array()) {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

    /**
     * 获取第一行的第一个字段值
     * @param type $sql
     * @param array $args
     * @return string
     */
    public function getOne($sql, array $args = array()) {
        //获取所有的实参
        $args   = func_get_args();
        //获取sql语句
        $sql    = array_shift($args);
        //将sql语句分隔
        $params = preg_split('/\?[NFT]/', $sql);
        //删除最后一个空元素
        array_pop($params);
        //sql变量已经没用了， 我们用来拼凑完整的sql语句
        $sql    = '';
        foreach ($params as $key => $value) {
            $sql .= $value . $args[$key];
        }
        //query返回一个二维数组
        $rows = M()->query($sql);
        //获取第一行
        $row  = array_shift($rows);
        //获取第一个字段值
        return array_shift($row);
    }

    /**
     * 获取一行记录
     * @param type $sql
     * @param array $args
     * @return array|null
     */
    public function getRow($sql, array $args = array()) {
        //获取所有的实参
        $args   = func_get_args();
        //获取sql语句
        $sql    = array_shift($args);
        //将sql语句分隔
        $params = preg_split('/\?[NFT]/', $sql);
        //删除最后一个空元素
        array_pop($params);
        //sql变量已经没用了， 我们用来拼凑完整的sql语句
        $sql    = '';
        foreach ($params as $key => $value) {
            $sql .= $value . $args[$key];
        }
        //query返回一个二维数组
        $rows = M()->query($sql);
        //我们只要第一行
        return array_shift($rows);
    }

    /**
     * 新增一条记录。
     * @param type $sql
     * @param array $args
     */
    public function insert($sql, array $args = array()) {
        //获取所有的实参
        $args       = func_get_args();
        $sql        = $args[0];
        $table_name = $args[1];
        $params     = $args[2];
        $sql        = str_replace('?T', $table_name, $sql);
        $tmp        = [];
        foreach ($params as $key => $value) {
            $tmp[] = $key . '="' . $value . '"';
        }
        $sql = str_replace('?%', implode(',', $tmp), $sql);
        if (M()->execute($sql) !== false) {
            return M()->getLastInsID();
        } else {
            return false;
        }
    }

    /**
     * 执行一个简单的sql语句
     * 待确认是否只是写语句。
     * @param type $sql
     * @param array $args
     * @return type
     */
    public function query($sql, array $args = array()) {

        //有可能是查询语句，所以如果是查询，就输出一些信息
        //获取所有的实参
        $args   = func_get_args();
        //获取sql语句
        $sql    = array_shift($args);
        //将sql语句分隔
        $params = preg_split('/\?[NFT]/', $sql);
        //删除最后一个空元素
        array_pop($params);
        //sql变量已经没用了， 我们用来拼凑完整的sql语句
        $sql    = '';
        foreach ($params as $key => $value) {
            $sql .= $value . $args[$key];
        }
        //执行一个写操作
        return M()->execute($sql);
    }

    public function update($sql, array $args = array()) {
        echo __METHOD__;
        dump(func_get_args());
        echo '<hr />';
    }

}
