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
        $mail->Host       = 'smtp.exmail.qq.com';  //填写发送邮件的服务器地址
        $mail->SMTPAuth   = true;                               // 使用smtp验证
        $mail->Username   = 'message@kunx.org';                 // 发件人账号名
        $mail->Password   = 'Ydm20160330';                           // 密码
        $mail->SMTPSecure = 'ssl';                            // 使用协议,具体是什么根据你的邮件服务商来确定
        $mail->Port       = 465;                                    // 使用的端口

        $mail->setFrom('message@kunx.org', 'kunx.org'); //发件人,注意:邮箱地址必须和上面的一致
        $mail->addAddress('kunx-edu@qq.com');     // 收件人

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = '欢迎注册啊咿呀哟母婴商城';
        $url           = U('Member/Active', ['email' => 'kunx-eud@qq.com'], true, true);
        $mail->Body    = '欢迎您注册我们的网站,请点击<a href="' . $url . '">链接</a>激活账号.如果无法点击,请复制以下链接粘贴到浏览器窗口打开!<br />' . $url;
        $mail->CharSet = 'UTF-8';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

}
