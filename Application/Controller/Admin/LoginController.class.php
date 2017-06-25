<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/14
 * Time: 12:37
 */
class LoginController extends Controller{
    public function login(){
//        显示登录页面
        $this->display("login");
    }
    public function check(){
        $data=$_POST;
        $loginModel= new LoginModel();
        $res=$loginModel->check($data);
        //验证验证码
        $captcha = $_POST['captcha'];
        //比对小写，不区分大小写
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){
            $this->alert( "验证码错误！", "index.php?p=Admin&c=Login&a=login" );
//            $this->redirect("index.php?p=Admin&c=Login&a=login","验证码错误！",3);
        }
        //        验证登录
        //        var_dump($res);exit;
        if($res===FALSE){
            $this->alert( "登录失败".$loginModel->getError(), "index.php?p=Admin&c=Login&a=login" );
//            $this->redirect("index.php?p=Admin&c=Login&a=login","登录失败".$loginModel->getError(),3);
        }
        $id=$res['member_id'];
//        var_dump($res);echo $time,"=",$ip,"=",$id;exit;
//        修改iptime
        $loginModel->ip_time($id);

        $_SESSION['user_info']=$res;
        if(isset($data['remember'])){
            $id=$res['member_id'];
            $password=md5($res['password']."_itsource");
            setcookie("id",$id,time()+3600*12,"/");
            setcookie("password",$password,time()+3600*12,"/");
        }
//        exit;
        //如果成功 跳转 到后台首页
        $this->alert( "欢迎您，管理员！", "index.php?p=Admin&c=Index&a=index" );
//        $this->redirect('index.php?p=Admin&c=Index&a=index');
    }
    public function logout(){
        //删除cookie中的id和password
        setcookie('id',null,-1,"/");
        setcookie('password',null,-1,"/");
        //删除session中的user_info
        unset($_SESSION['user_info']);
        //跳转到登陆页面
        $this->alert( "退出成功", "index.php?p=Admin&c=Login&a=login" );
//        $this->redirect("index.php?p=Admin&c=Login&a=login","退出成功！",1);
    }
}