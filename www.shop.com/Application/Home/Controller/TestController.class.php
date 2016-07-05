<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of TestController
 *
 * @author qingf
 */
class TestController extends \Think\Controller {

    public function sms() {
        //发送短信
        //引入topSdk.php
        Vendor('Alidayu.TopSdk');
        $c            = new \TopClient;
        $c->appkey    = '23399157';
        $c->secretKey = '9c636f9add5b83d92b0b408a04b09075';
        $req          = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("徐亚520");
        $req->setSmsParam("{'product':'哎咿呀哟','code':'4563'}");
        $req->setRecNum("13981724605");
        $req->setSmsTemplateCode("SMS_11495217");
        $resp         = $c->execute($req);
    }

}
