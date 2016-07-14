<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of TestController
 *
 * @author qingf
 */
class TestController extends \Think\Controller{
    //put your code here
    public function sendMail() {
        $addresses = [
            'tzaerdcb@sharklasers.com','nazayuqm@sharklasers.com','hstqxdti@sharklasers.com'
        ];
        $pool = [];
        $start = microtime(true);
        foreach($addresses as $address){
            $obj = new MyMailThread($address,'哟呵,大爷您来了','小翠,快来招呼雷少爷');
            $pool[] = $obj;
            $obj->start();
        }
        $end = microtime(true);
        echo '共耗时' . ($end-$start) . ' s';
        
    }
}

class MyMailThread extends \Thread{
    private $email,$subject,$content;
    
    public function __construct($email, $subject, $content) {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
    }
    public function run() {
        sendMail($this->email, $this->subject, $this->content);
    }
}
