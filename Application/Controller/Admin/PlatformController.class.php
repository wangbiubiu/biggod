<?php

/**
 * 平台统一验证控制器
 */
class PlatformController extends Controller
{
    public function __construct()
    {
        //验证是否登陆
        $result = $this->checkLogin();
        if($result === false){
            //跳转到登陆页面
//            $this->alert( "没有登陆", "index.php?p=Admin&c=Login&a=login" );
            $this->redirect("index.php?p=Admin&c=Login&a=login","没有登陆",3);
        }
    }

    /**
     * 验证登陆信息
     * 成功返回 true，失败返回 false
     */
    private function checkLogin(){
        //验证session中登陆信息
        @session_start();
        if(!isset($_SESSION['user_info'])){
            //1，判定cookie中是否有id和password
            if(isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                //2. 如果有，将id和password取出来到数据库中判定
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                $adminModel = new LoginModel();
                //验证cookie中的id和password是否正确 验证失败 返回 false
                $result = $adminModel->checkByCookie($id,$password);
//                var_dump($result);exit;
                if($result !== false){//验证成功
                    //记录登陆信息到session中
                    $_SESSION['user_info'] = $result;
                    return true;
                }
            }
            //3. 如果没有,跳转到登陆页面
            //跳转到登陆页面
            return false;
        }
    }
}