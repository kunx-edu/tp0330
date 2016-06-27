<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of UploadController
 *
 * @author qingf
 */
class UploadController extends \Think\Controller {

    /**
     * 上传图片。
     */
    public function uploadImg() {
        //创建upload对象
        $options   = C('UPLOAD_SETTING');
        $upload    = new \Think\Upload($options);
        $file_info = $upload->uploadOne($_FILES['file_data']); //获取上传文件的信息
        //上传成功返回文件的完整路径，失败返回错误信息
        if ($file_info) {
            if($upload->driver == 'Qiniu'){
                $file_url = $file_info['url'];
            } else{
                $file_url = BASE_URL . '/' . $file_info['savepath'] . $file_info['savename'];
            }
            $return = [
                'file_url' => $file_url,
                'msg'      => '上传成功',
                'status'   => 1,
            ];
        } else {
            $return = [
                'file_url' => '',
                'msg'      => $upload->getError(),
                'status'   => 0,
            ];
        }
        $this->ajaxReturn($return);
    }

}
