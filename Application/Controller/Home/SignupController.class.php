<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/14
 * Time: 13:10
 */
class SignupController extends Controller{
//    前台注册
    public function signup(){
//        添加注册信息
        if($_SERVER["REQUEST_METHOD"]=="POST"){
//            接收注册页面传来的数据
            $data=$_POST;
            //            var_dump($data);exit;
            $photo=$_FILES['photo'];
            //            echo "<pre>";
//                        var_dump($photo);exit;
//            exit;
            $uploadModel = new UploadModel();
            //            上传成功 返回路径；失败返回false
            $logo_path = $uploadModel->uploadOne($photo,"photo/");

            if($logo_path===FALSE){
                $this->alert( "上传图片失败！".$uploadModel->getError(), "index.php?p=Home&c=Goods&a=add" );
//                $this->redirect("index.php?p=Home&c=Goods&a=add","上传图片失败！".$uploadModel->getError(),3);
            }
            else{
                //路径保存到$data中 添加
                $data['photo'] = $logo_path;
            }
//            var_dump($data);exit;

//            调用模型注册
            $signupModel=new SignupModel();
            $res=$signupModel->user($data);
//            注册失败给出提示
            if($res===FALSE){
                $this->alert( "注册失败，".$signupModel->getError(), "index.php?p=Home&c=Signup&a=signup" );
//                $this->redirect("index.php?p=Home&c=Signup&a=signup","注册失败，".$signupModel->getError(),3);
            }
//            注册成功跳转至登录界面
            $this->alert( "注册成功!", "index.php?p=Home&c=Login&a=login" );
//            $this->redirect("index.php?p=Home&c=Login&a=login");
        }else{
        //        显示注册界面
        $this->display("signup");}
    }
}