<?php


namespace Common\Behaviors;

class CheckPermissionBehavior extends \Think\Behavior{
    public function run(&$params) {
        //获取并验证权限
        $url = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        
        //获取用户信息
        $userinfo = login();
        if(isset($userinfo['username']) && $userinfo['username'] == 'admin'){
            return true;
        }
        
        $ignore_setting = C('ACCESS_IGNORE');
        //获取权限列表
        $pathes = permission_pathes();
        //配置所有用户都可以访问的页面
        $ignore = $ignore_setting['IGNORE'];
        //登陆用户可见页面
        $user_ignore = $ignore_setting['USER_IGNORE'];
        
        //允许访问的页面有,角色处获取的权限和忽略列表
        $urls = array_merge($pathes,$ignore);
        if($userinfo){
            //登陆用户可见页面还要额外加上登陆后的忽略列表
            $urls = array_merge($urls,$user_ignore);
        }
        
        if(!in_array($url, $urls)){
            header('Content-Type: text/html;charset=utf-8');
            redirect(U('Admin/Admin/login'), 3, '无权访问');
        }
    }

}
