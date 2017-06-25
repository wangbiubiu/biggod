<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/14
 * Time: 12:37
 */
class LoginController extends Controller{
    public function login(){
//        显示会员登录页面
        $this->display("login");
    }
    public function check(){
        $data=$_POST;
        $loginModel= new LoginModel();
        $res=$loginModel->check2($data);
        //验证验证码
        $captcha = $_POST['captcha'];
        //比对小写，不区分大小写
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){

            $this->alert( "验证码错误！", "index.php?p=Home&c=Login&a=login" );
//            $this->redirect("index.php?p=Home&c=Login&a=login","验证码错误！",3);
        }
        //        验证登录
        //        var_dump($res);exit;
        if($res===FALSE){
            $this->alert( "登录失败，".$loginModel->getError(), "index.php?p=Home&c=Login&a=login" );
//            $this->redirect("index.php?p=Home&c=Login&a=login","登录失败".$loginModel->getError(),3);
        }
        $_SESSION['user_info1']=$res;
        if(isset($data['remember'])){
            $id=$res['user_id'];
            $password=md5($res['password']."_itsource");
            setcookie("id",$id,time()+3600*12,"/");
            setcookie("password",$password,time()+3600*12,"/");
        }
        //如果成功 跳转 到后台首页
        $this->alert( "欢迎！", "index.php?p=Home&c=Index&a=index" );
//        $this->redirect('index.php?p=Home&c=Index&a=index');
    }
    public function logout(){
        //删除cookie中的id和password
        setcookie('id',null,-1,"/");
        setcookie('password',null,-1,"/");
        //删除session中的user_info
        unset($_SESSION['user_info1']);
        //跳转到登陆页面
        $this->alert( "退出成功！", "index.php?p=Home&c=Login&a=login" );
//        $this->redirect("index.php?p=Home&c=Login&a=login","退出成功！",1);
    }
}