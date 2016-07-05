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

    public function sendEmail() {
        Vendor('PHPMailer.PHPMailerAutoload');

        $mail = new \PHPMailer;


        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host       = 'smtp.126.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $mail->Username   = 'kunx_edu@126.com';                 // SMTP username
        $mail->Password   = 'iam4ge';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to

        $mail->setFrom('kunx_edu@126.com', 'ayiyayo');
        $mail->addAddress('kunx-edu@qq.com', 'brother four');     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = '欢迎注册啊咿呀哟母婴商城';
        $url = U('Member/Active',['email'=>'kunx-eud@qq.com'],true,true);
        $mail->Body    = '欢迎您注册我们的网站,请点击<a href="'.$url.'">链接</a>激活账号.如果无法点击,请复制以下链接粘贴到浏览器窗口打开!<br />' . $url;
        $mail->CharSet = 'UTF-8';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

}
